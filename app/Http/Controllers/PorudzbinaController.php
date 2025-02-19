<?php

namespace App\Http\Controllers;

use App\Models\IgrackaBoje;
use App\Models\IgrackaKombinacija;
use App\Models\Korpa;
use App\Models\LogProdaje;
use App\Models\MaterijalKombinacija;
use App\Models\Posiljka;
use App\Models\Racun;
use App\Models\StavkaKorpe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PorudzbinaController extends Controller{

    public function dodajUKorpu()
    {
        $korisnik = Auth::user();

        // Pronađi ili kreiraj korpu za trenutno ulogovanog korisnika
        $korpa = Korpa::firstOrCreate(
            ['idKorisnik' => $korisnik->getAuthIdentifier()],
            ['ukupna_cena' => 0]  // Postavi početnu vrednost za ukupnu cenu
        );

        // Proveri da li se prosleđuje igračka ili materijal
        $idIgrKomb = request()->input('idIgrKomb');  // Kombinacija igračke
        $idMatKomb = request()->input('idMatKomb');  // Kombinacija materijala
        $kolicina = request()->input('kolicina');

        // Proveri da li je dodata igračka ili materijal
        if ($idIgrKomb) {
            // Dodaj igračku u korpu
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

        return response()->json(['success' => true, 'message' => 'Proizvod je uspešno dodat u korpu!']);
    }

    public function korpa()
    {
        $korisnik = Auth::user();

        // Pronađi korpu trenutnog korisnika
        $korpa = Korpa::where('idKorisnik', $korisnik->getAuthIdentifier())->first();

        if ($korpa) {
            $stavkeKorpe = $korpa->stavke;
            //dd($stavkeKorpe);
            $ukupnaCena = 0;

            // Izračunaj ukupnu cenu sabiranjem cena svih stavki
            foreach ($stavkeKorpe as $stavka) {
                if($stavka->nacin_pravljenja == 'samostalno'){
                    $stavka->igracka->cena_pravljenja = 0;
                }

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


        // Validacija korisničkih podataka
        $attributes = request()->validate([
            'ime' => ['required'],
            'prezime' => ['required'],
            'mejl' => ['required'],
            'telefon' => ['required'],
            'adresa_placanja' => ['required'],
            'adresa_isporuke' => ['required'],
            'metod_placanja' => ['required']
        ], [], ["adresa_placanja" => 'adresa plaćanja',
                "metod_placanja" => 'metod plaćanja',]);

        // Kreiranje nove pošiljke
        $posiljka = Posiljka::create([
            'adresa_placanja' => $attributes['adresa_placanja'],
            'adresa_isporuke' => $attributes['adresa_isporuke'],
            'status_posiljke' => 'u izradi', // Postavi početni status
            'vreme_statusa' => now(),
            'idKorisnik' => $korisnik->getAuthIdentifier(),
            'ime_p' => $attributes['ime'],
            'prezime_p' => $attributes['prezime'],
            'mejl_p' => $attributes['mejl'],
            'telefon_p' => $attributes['telefon'],
        ]);


        // Proveri metod plaćanja
        $metodPlacanja = $attributes['metod_placanja'];

        $datumPlacanja = null;

        if($metodPlacanja == 2){
            $datumPlacanja = now();
        }

        // Kreiranje računa nakon pošiljke
        $racun = Racun::create([
            'idMetodPlacanja' => $metodPlacanja,
            'idPosiljka' => $posiljka->idPosiljka,
            'datum_vreme_izdavanjaR' => now(),
            'datum_vreme_placanja' => $datumPlacanja,
            'iznos' => request()->input('ukupan_iznos'),
            'idKorisnik' => $korisnik->getAuthIdentifier(),
        ]);


        foreach ($korpa->stavke as $stavka) {

            // Zapis u LogProdaje
            LogProdaje::create([
                'idKorisnik' => $korisnik->getAuthIdentifier(),
                'idIgrKomb' => $stavka->idIgrKomb,
                'idMatKomb' => $stavka->idMatKomb,
                'idRacun' => $racun->idRacun,
            ]);

            // Ako je stavka materijal, smanji kolicinu
            if ($stavka->idMatKomb) {
                // Smanji količinu za taj materijal
                $materijalKombinacija = MaterijalKombinacija::find($stavka->idMatKomb);
                if ($materijalKombinacija) {
                    $materijalKombinacija->kolicina_m -= $stavka->kolicina_s;
                    $materijalKombinacija->save();
                }
            }

            // Ako je stavka igračka
            if ($stavka->idIgrKomb) {
                $igrackaKombinacija = IgrackaKombinacija::find($stavka->idIgrKomb);
                if ($igrackaKombinacija) {
                    // Nađi boje za vunicu i oči iz igracka_boje
                    $igrackaBoje = IgrackaBoje::find($igrackaKombinacija->idIgrBoje);
                    if ($igrackaBoje) {

                        // Pronađi materijal za vunicu (koristi 1m po igrački)
                        $vunicaKombinacija = MaterijalKombinacija::where('idMatBoja', $igrackaBoje->idBojaVunice)
                            ->where('idDimenzije', 13) // 13 - 1m
                            ->first();

                        if ($vunicaKombinacija) {
                            $vunicaKombinacija->kolicina_m -= 1 * $stavka->kolicina_s;
                            $vunicaKombinacija->save();
                        }

                        // Pronađi materijal za oči (koristi 2cm po igrački)
                        $ociKombinacija = MaterijalKombinacija::where('idMatBoja', $igrackaBoje->idBojaOciju)
                            ->where('idDimenzije', 10) // 10 - 2cm
                            ->first();

                        if ($ociKombinacija) {
                            $ociKombinacija->kolicina_m -= 1 * $stavka->kolicina_s;
                            $ociKombinacija->save();
                        }
                    }
                }
            }

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

        return view('porudzbine.racun', compact('racun'));
    }
}
