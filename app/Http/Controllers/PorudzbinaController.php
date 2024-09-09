<?php

namespace App\Http\Controllers;

use App\Models\Korpa;
use App\Models\LogProdaje;
use App\Models\Posiljka;
use App\Models\Racun;
use App\Models\StavkaKorpe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PorudzbinaController extends Controller{

    public function dodajUKorpu()
    {
        $korisnik = Auth::user();

        // Find or create the cart for the user
        $korpa = Korpa::firstOrCreate(
            ['idKorisnik' => $korisnik->getAuthIdentifier()],
            ['ukupna_cena' => 0]  // Postavi pocetnu vrednost za ukupnu cenu
        );

        // Proveri da li se prosledjuje igracka ili materijal
        $idIgrKomb = request()->input('idIgrKomb');  // Kombinacija igracke
        $idMatKomb = request()->input('idMatKomb');  // Kombinacija materijala
        $kolicina = request()->input('kolicina');

        //dd($kolicina);
        //dd($idIgrKomb);

        // Proveri da li je dodata igracka ili materijal
        if ($idIgrKomb) {
            // Dodaj igracku u korpu
            $stavkaKorpe = StavkaKorpe::create([
                'idKorpa' => $korpa->idKorpa,
                'idIgrKomb' => $idIgrKomb,
                'kolicina_s' => $kolicina,
                'nacin_pravljenja' => 'gotova igračka', //default
            ]);
        } elseif ($idMatKomb) {
            // Dodaj materijal u korpu
            $stavkaKorpe = StavkaKorpe::create([
                'idKorpa' => $korpa->idKorpa,
                'idMatKomb' => $idMatKomb,
                'kolicina_s' => $kolicina,
            ]);
        }

//        dd($stavkaKorpe);

        // Optionally return a success message or redirect to the cart page
        return redirect()->route('porudzbine.korpa')->with('success', 'Proizvod je uspešno dodat u korpu.');
    }

    public function korpa()
    {
        $korisnik = Auth::user();

        // Find the user's cart
        $korpa = Korpa::where('idKorisnik', $korisnik->getAuthIdentifier())->first();

        if ($korpa) {
            $stavkeKorpe = $korpa->stavke;
            $ukupnaCena = 0;

            // Izračunaj ukupnu cenu sabiranjem cena svih stavki
            foreach ($stavkeKorpe as $stavka) {
                if (isset($stavka->igracka)) {
                    $cenaStavke = ($stavka->igracka->cena_pravljenja +
                        $stavka->igracka->boje->bojaVunice->kombinacije->first()->cena_m +
                        $stavka->igracka->boje->bojaOciju->kombinacije->first()->cena_m);

                    $ukupnaCena += $cenaStavke * $stavka->igracka->stavkaKorpe->first()->kolicina_s;
                } elseif (isset($stavka->materijal)) {
                    $cenaStavke = $stavka->materijal->cena_m;
                    $ukupnaCena += $cenaStavke * $stavka->materijal->stavkaKorpe->first()->kolicina_s;
                }
            }

            //dd($ukupnaCena);
            $korpa->ukupna_cena = $ukupnaCena;
            $korpa->save();

        } else {
            $stavkeKorpe = collect(); //ako nema korpe vraca se prazan niz
            $ukupnaCena = 0;
        }

        //dd($stavkeKorpe);

        // Return the view with cart items
        return view('porudzbine.korpa', compact('stavkeKorpe', 'ukupnaCena'));
    }

    public function ukloniStavku($id){
        // Pronađi stavku u korpi
        $stavka = StavkaKorpe::findOrFail($id);

        // Obrisi stavku
        $stavka->delete();

        // Redirektuj nazad na korpu sa porukom o uspešnom brisanju
        return redirect()->route('porudzbine.korpa')->with('success', 'Stavka je uspešno uklonjena iz korpe.');
    }

    public function azurirajNacinPravljenja()
    {
        // Pronađi stavku na osnovu ID-a koji je poslat iz AJAX zahteva
        $stavka = StavkaKorpe::findOrFail(request()->input('stavkaId'));

        // Ažuriraj način pravljenja
        $stavka->nacin_pravljenja = request()->input('nacin_pravljenja');
        //dd($stavka);
        $stavka->save();

        return response()->json(['message' => 'Način pravljenja je uspešno ažuriran.']);
    }

    public function azurirajKolicinu()
    {
        // Pronađi stavku na osnovu ID-a koji je poslat iz AJAX zahteva
        $stavka = StavkaKorpe::findOrFail(request()->input('stavkaId'));

        // Ažuriraj način pravljenja
        $stavka->kolicina_s = request()->input('kolicinaStavke');
        //dd($stavka);
        $stavka->save();

        return response()->json(['message' => 'Način pravljenja je uspešno ažuriran.']);
    }


    public function porudzbina(){
        $korisnik = Auth::user();
        $korpa = Korpa::where('idKorisnik', $korisnik->getAuthIdentifier())->first();

        $ukupnaCenaKorpe = $korpa->ukupna_cena;
        $popust = request()->input('popust');

        $ukupnaCenaKorpe = $ukupnaCenaKorpe * $popust;
        //dd($ukupnaCenaKorpe);

        $cenaDostave = 480;  // Postavljena fiksna cena dostave

        $ukupanIznos = $ukupnaCenaKorpe + $cenaDostave;

        return view('porudzbine.porudzbina', compact('ukupanIznos'));
    }

    public function zavrsiPorudzbinu()
    {
        $korisnik = Auth::user();
        $korpa = Korpa::where('idKorisnik', $korisnik->getAuthIdentifier())->first();

        $adresa_placanja = request()->input('adresa-placanja');
        //dd($adresa_placanja);
        //provera da li se lepo prosledjuju podaci

        // Kreiranje nove pošiljke
        $posiljka = Posiljka::create([
            'adresa_placanja' => request()->input('adresa-placanja'),
            'adresa_isporuke' => request()->input('adresa-isporuke'),
            'status_posiljke' => 'u izradi', // Postavi početni status
            'vreme_statusa' => now(),
            'idKorisnik' => $korisnik->getAuthIdentifier(),
            'ime_p' => request()->input('ime'),
            'prezime_p' => request()->input('prezime'),
            'mejl_p' => request()->input('mejl'),
            'telefon_p' => request()->input('telefon'),
        ]);

        // Proveri metod plaćanja
        $metodPlacanja = request()->input('metod-placanja');
        if($metodPlacanja === 'kartica'){
            $metodPlacanja = 1;
        }
        elseif($metodPlacanja === 'po preuzeću'){
            $metodPlacanja = 2;
        }

        //dd($metodPlacanja);
        $datumPlacanja = null;

        if ($metodPlacanja == 1) {
            // Ako je kartica, postavi vreme plaćanja
            $datumPlacanja = now();
        }

//        $iznos = request()->input('ukupan_iznos');
//        dd($iznos);

        // Kreiranje računa nakon pošiljke
        $racun = Racun::create([
            'idMetodPlacanja' => $metodPlacanja,
            'idPosiljka' => $posiljka->idPosiljka,
            'datum_vreme_izdavanjaR' => now(),
            'datum_vreme_placanja' => $datumPlacanja,
            'iznos' => request()->input('ukupan_iznos'),
            'idKorisnik' => $korisnik->getAuthIdentifier(),
        ]);

        // Zapis u LogProdaje
        foreach ($korpa->stavke as $stavka) {
            LogProdaje::create([
                'idKorisnik' => $korisnik->getAuthIdentifier(),
                'idIgrKomb' => $stavka->idIgrKomb,
                'idMatKomb' => $stavka->idMatKomb,
                'idRacun' => $racun->idRacun,
            ]);
        }

        // Isprazni korpu
        $korpa->stavke()->delete();

        return redirect()->route('racun')->with('racun', $racun);
    }

    public function racun(){

        // Uzmite račun iz session-a nakon završenog procesa narudžbine
        $racun = session('racun');

        if (!$racun) {
            return redirect()->route('racun')->with('error', 'Nema dostupnog računa.');
        }

        return view('racun');
    }
}
