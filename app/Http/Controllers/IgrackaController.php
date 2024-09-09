<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\IgrackaBoje;
use App\Models\IgrackaKombinacija;
use Illuminate\Http\Request;

class IgrackaController extends Controller
{

    public function index(Request $request)
    {
        //$igracke = Igracka::with('defaultBoje.slika', 'defaultKombinacija')->get();

        // Definiši sortiranje
        $sortOption = $request->input('sort');

        //$query = Igracka::with(['defaultBoje.slika', 'defaultKombinacija']);
        //upit osnovni pre selecta
        $query = Igracka::with(['defaultBoje.slika', 'defaultKombinacija' => function($query) {
            $query->orderBy('cena_pravljenja', 'asc');
        }]);

        switch ($sortOption) {
            case '1':
                $query = Igracka::select('igracka.idIgracka', 'igracka.naziv_i') //umesto select * jer onda svaki atribut mora biti u groupby
                    ->join('igracka_boje', 'igracka.idIgracka', '=', 'igracka_boje.idIgracka')
                    ->join('igracka_kombinacija', 'igracka_boje.idIgrBoje', '=', 'igracka_kombinacija.idIgrBoje')
                    ->groupBy('igracka.idIgracka', 'igracka.naziv_i')
                    ->orderBy('igracka_kombinacija.cena_pravljenja', 'asc');

                break;
            case '2':
                $query = Igracka::select('igracka.idIgracka', 'igracka.naziv_i')
                    ->join('igracka_boje', 'igracka.idIgracka', '=', 'igracka_boje.idIgracka')
                    ->join('igracka_kombinacija', 'igracka_boje.idIgrBoje', '=', 'igracka_kombinacija.idIgrBoje')
                    ->groupBy('igracka.idIgracka', 'igracka.naziv_i')
                    ->orderBy('igracka_kombinacija.cena_pravljenja', 'desc');
                break;
            case '3':
                $query = $query->orderBy('naziv_i', 'asc');
                break;
            case '4':
                $query = $query->orderBy('naziv_i', 'desc');
                break;
            case '5':
                $query = $query->latest();  // Sortiranje po najnovijim
                break;
            default:
                $query = $query->orderBy('naziv_i', 'asc');  // Default sortiranje
        }

        // Dohvati sve igračke sa primenjenim sortiranjem
        //$igracke = $query->get();

        // Paginacija sa 8 rezultata po stranici
        $igracke = $query->paginate(8);

        // Izračunaj ukupnu cenu za svaku igračku
        foreach ($igracke as $igracka) {
            $cenaVunice = optional($igracka->defaultBoje->bojaVunice->defaultKombinacija)->cena_m ?? 0;
            $cenaOciju = optional($igracka->defaultBoje->bojaOciju->defaultKombinacija)->cena_m ?? 0;
            $igracka->ukupnaCena = $igracka->defaultKombinacija->cena_pravljenja + $cenaVunice + $cenaOciju;
        }

        $igracke->appends(['sort' => $sortOption]); //da se sortiranje prebaci i na druge strane
        return view('igracke.index', ['igracke' => $igracke, 'selectedSort' => $sortOption]);
        //sort option da se ne bi odmah nakon sortiranja refreshovao select
    }

    public function show($id)
    {
        // Prikaz pojedinačne igračke
        $igracka = Igracka::with([
            'defaultBoje.slika',
            'defaultKombinacija',
            'boje.bojaVunice.boja',
            'boje.bojaOciju.boja',
            'kombinacije.dimenzija'
        ])->findOrFail($id);

        //dd($igracka->boje->pluck('bojaVunice.boja')); // Check if the correct data is retrieved

        // Prikupite dostupne boje vunice i očiju za igracku
        $bojeVunice = $igracka->boje->pluck('bojaVunice')->unique('idBoja');
        //dd($bojeVunice);
        $bojeOciju = $igracka->boje->pluck('bojaOciju')->unique('idBoja');

        // Prikupite sve dimenzije dostupne za igračku zajedno sa cenom iz kombinacija
        $dimenzije = $igracka->kombinacije->map(function ($kombinacija) {
            return [
                'idDimenzije' => $kombinacija->dimenzija->idDimenzije,
                'naziv_d' => $kombinacija->dimenzija->naziv_d,
                'cena_pravljenja' => $kombinacija->cena_pravljenja,
            ];
        })->unique('idDimenzije');

        // Definišite defaultne boje za igracku
        $defaultBojaVunice = $bojeVunice->first()->boja->naziv_b ?? 'Ne postoji default boja vunice';
        if($defaultBojaVunice == 'žuta'){
            $defaultBojaVunice = 'zuta';
        }
        $defaultBojaOciju = $bojeOciju->first()->boja->naziv_b ?? 'Ne postoji default boja očiju';

        return view('igracke.show',
            compact('igracka',
                'bojeVunice',
                'bojeOciju',
                'dimenzije',
                'defaultBojaVunice',
                'defaultBojaOciju'));
    }


    public function getIgrackaKombinacija()
    {
        $idIgracka = request()->input('idIgracka');
        $idBojaVunice = request()->input('idBojaVunice');
        $idBojaOciju = request()->input('idBojaOciju');
        $idDimenzije = request()->input('idDimenzije');

        $igracka = Igracka::find($idIgracka);

        // Proveri da li si pronašao igračku
        if (!$igracka) {
            return response()->json(['error' => 'Igračka nije pronađena'], 404);
        }

        // Pronađi odgovarajući zapis u tabeli igracka_boje gde su povezani boje vunice i očiju
        $igrackaBoje = IgrackaBoje::where('idIgracka', '=', $idIgracka)
            ->where('idBojaVunice', '=', $idBojaVunice)
            ->where('idBojaOciju', '=', $idBojaOciju)
            ->first();

        //return response()->json(['success' => $igrackaBoje], 200);


        // Proveri da li si pronašao boje za igračku
        if (!$igrackaBoje) {
            return response()->json(['error' => 'Boje za igračku nisu pronađene'], 402);
        }

        $igrackaKombinacija = IgrackaKombinacija::where('idIgrBoje', '=', $igrackaBoje->idIgrBoje)
            ->where('idDimenzije', '=', $idDimenzije)
            ->first();

        //return response()->json(['success' => $igrackaKombinacija], 200);

        // Proveri da li si pronašao kombinaciju sa dimenzijama
        if (!$igrackaKombinacija) {
            return response()->json(['error' => 'Kombinacija nije pronađena'], 405);
        }

        return response()->json([
            'idIgrKomb' => $igrackaKombinacija->idIgrKomb,
        ]);

//        if (!$igrackaBoje) {
//            //return response()->json(['error' => 'Kombinacija nije pronađena'], 404);
//            return response()->json([$igrackaBoje]);
//        }

//        if ($igrackaKombinacija) {
//            return response()->json([
//                'idIgrKomb' => $igrackaKombinacija->idIgrKomb,
//                //'cena' => $igrackaKombinacija->cena_pravljenja
//            ]);
//        } else {
//            return response()->json(['idIgrKomb' => $igrackaKombinacija->idIgrKomb]);
//            //return response()->json(['error' => 'Kombinacija nije pronađena'], 404);
//        }
    }

}
