<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\Korisnik;
use App\Models\LogProdaje;
use App\Models\Materijal;
use App\Models\Posiljka;
use App\Models\Racun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class KorisnikController extends Controller
{
    // Prikaz stranice za profil
    public function index()
    {
        $korisnik = Auth::user();

        // Prikaz samo porudžbina trenutnog korisnika
        $aktuelnePorudzbine = Posiljka::where('idKorisnik', $korisnik->getAuthIdentifier())
            ->where('status_posiljke', '!=', 'isporučena')
            ->with('racun.metodPlacanja')
            ->orderBy('created_at', 'desc')
            ->get();

        $prethodnePorudzbine = Posiljka::where('idKorisnik', $korisnik->getAuthIdentifier())
            ->where('status_posiljke', 'isporučena')
            ->with('racun.metodPlacanja')
            ->orderBy('created_at', 'desc')
            ->get();

        $korisnici = Korisnik::all(); // Za prikaz svih korisnika u select meniju ako je neko admin ili kurir
        return view('korisnici.nalog.index', compact('korisnik', 'aktuelnePorudzbine', 'prethodnePorudzbine', 'korisnici'));
    }

    public function getPorudzbineForUser($idKorisnik)
    {
        $korisnik = Auth::user();

        // Provera da li je korisnik admin ili kurir
        if ($korisnik->getTipKor() == 1 || $korisnik->getTipKor() == 3) {
            // Prikaz aktuelnih porudžbina za odabranog korisnika
            $aktuelnePorudzbine = Posiljka::where('idKorisnik', $idKorisnik)
                ->where('status_posiljke', '!=', 'isporučena')
                ->with('racun.metodPlacanja')
                ->orderBy('created_at', 'desc')
                ->get();

            // Prikaz prethodnih porudžbina za odabranog korisnika
            $prethodnePorudzbine = Posiljka::where('idKorisnik', $idKorisnik)
                ->where('status_posiljke', 'isporučena')
                ->with('racun.metodPlacanja')
                ->orderBy('created_at', 'desc')
                ->get();

            $korisnici = Korisnik::all();

            // Vraćamo HTML partial za AJAX poziv
            return view('korisnici.nalog.partials.porudzbine', compact('aktuelnePorudzbine', 'prethodnePorudzbine'))->render();
        }

        // Ako korisnik nije admin ili kurir
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Izmena podataka korisnika
    public function izmeniPodatke()
    {
        $korisnik = Auth::user();

        $attributes = request()->validate([
            'ime' => ['required'],
            'prezime' => ['required'],
            'mejl' => 'required|email|unique:korisnik,mejl,' . $korisnik->getAuthIdentifier() . ',idKorisnik', //umesto idKorisnik
            'kor_ime' => 'required|unique:korisnik,kor_ime,' . $korisnik->getAuthIdentifier() . ',idKorisnik',
            'adresa_kor' => ['nullable'],
        ], [
            //prilagodjene poruke o greskama
        ],
        ['kor_ime' => 'korisničko ime']);

        $korisnik->update($attributes);

        return redirect()->back()->with('success1', 'Podaci su uspešno ažurirani.');
    }

    // Reset lozinke
    public function resetujLozinku()
    {
        $korisnik = Auth::user();

        request()->validate([
            'trenutna_lozinka' => 'required',
            'nova_lozinka' => ['required', 'confirmed', Password::min(8)
                                                        ->mixedCase() // Bar jedno veliko i malo slovo
                                                        ->numbers() // Bar jedan broj
                                                        ->symbols() // Bar jedan specijalni znak
            ],
        ]);

        if (!Hash::check(request()->trenutna_lozinka, $korisnik->getAuthPassword())) {
            return back()->withErrors(['trenutna_lozinka' => 'Trenutna lozinka nije ispravna.']);
        }

        $korisnik->update(['lozinka' => Hash::make(request()->nova_lozinka)]);

        return redirect()->back()->with('success2', 'Lozinka je uspešno resetovana.');
    }

    public function getMeseciGodine()
    {
        // Dohvati sve godine i mesece iz kolone 'created_at'
        $datumi = LogProdaje::selectRaw('YEAR(created_at) as godina, MONTH(created_at) as mesec')
            ->groupBy('godina', 'mesec')
            ->orderBy('godina', 'desc')
            ->orderBy('mesec', 'desc')
            ->get();

        // Kreiraj odgovor
        return response()->json($datumi);
    }

    public function getStatistika()
    {
        $mesec = request()->input('mesec'); //9
        $godina = request()->input('godina'); //2024

        if (!$mesec || !$godina) {
            return response()->json(['error' => 'Mesec i godina su obavezni.'], 400);
        }

        // Ukupan broj prodaja za odabrani mesec i godinu
        $prodaje = LogProdaje::whereYear('created_at', $godina)
            ->whereMonth('created_at', $mesec)
            ->get();

        $ukupanBrojProdajaMesec = $prodaje->count();


        // Ukupna zarada iz tabele racun SAMO za taj MESEC u godini
        $ukupnaZaradaMesec = Racun::whereHas('logProdaje', function($query) use ($mesec, $godina) {
            $query->whereYear('created_at', $godina)
                ->whereMonth('created_at', $mesec);
        })->sum('iznos');


        // Zarada po SVIM mesecima u godini (za grafikon)
        $zaradaPoMesecima = Racun::selectRaw('MONTH(datum_vreme_izdavanjaR) as mesec, SUM(iznos) as zarada')
            ->whereYear('datum_vreme_izdavanjaR', $godina)
            ->groupBy('mesec')
            ->pluck('zarada', 'mesec')->toArray();

        Log::info($zaradaPoMesecima);

        // Svi meseci (od 1 do 12) treba da budu pokriveni, dodeli 0 ako nema zarade
        $zaradaZaSveMesece = [];
        for ($i = 1; $i <= 12; $i++) {
            $zaradaZaSveMesece[$i] = $zaradaPoMesecima[$i] ?? 0;
        }

        // Broj prodaja po proizvodu
        $igracke = Igracka::all(); // Nazivi igračaka
        $materijali = Materijal::all(); // Nazivi materijala


        return response()->json([
            'ukupanBrojProdajaMesec' => $ukupanBrojProdajaMesec,
            'ukupnaZaradaMesec' => $ukupnaZaradaMesec,
            'zaradaPoMesecima' => $zaradaPoMesecima,
            'ukupnaZaradaGodina' => array_sum($zaradaZaSveMesece),
            'igracke' => $igracke,
            'materijali' => $materijali
        ]);
    }

    public function getBrojProdajaProizvoda()
    {
        $mesec = request()->input('mesec');
        $godina = request()->input('godina');
        $proizvodId = request()->input('proizvodId');
        $tipProizvoda = request()->input('tipProizvoda'); // "igracka" ili "materijal"
//        Log::info($mesec);
//        Log::info($godina);
//        Log::info($proizvodId);
//        Log::info($tipProizvoda);

        if ($tipProizvoda == 'igracka') {
            // Broj prodaja za igračku
            $brojProdaja = LogProdaje::join('igracka_kombinacija', 'log_prodaje.idIgrKomb', '=', 'igracka_kombinacija.idIgrKomb')
                ->join('igracka_boje', 'igracka_kombinacija.idIgrBoje', '=', 'igracka_boje.idIgrBoje')
                ->where('igracka_boje.idIgracka', $proizvodId)
                ->whereYear('log_prodaje.created_at', $godina)
                ->whereMonth('log_prodaje.created_at', $mesec)
                ->count();
        }
        else if($tipProizvoda == 'materijal')
        {
            // Broj prodaja za materijal
            $brojProdaja = LogProdaje::join('materijal_kombinacija', 'log_prodaje.idMatKomb', '=', 'materijal_kombinacija.idMatKomb')
                ->join('materijal_boja', 'materijal_kombinacija.idMatBoja', '=', 'materijal_boja.idMatBoja')
                ->where('materijal_boja.idMaterijal', $proizvodId)
                ->whereYear('log_prodaje.created_at', $godina)
                ->whereMonth('log_prodaje.created_at', $mesec)
                ->count();
        }

        //Log::info($brojProdaja);

        return response()->json(['brojProdaja' => $brojProdaja]);
    }

}

