<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
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
        $igracke = $query->get();

        //dd($igracke->pluck('defaultKombinacija.cena_pravljenja'));

        // Izračunaj ukupnu cenu za svaku igračku
//        foreach ($igracke as $igracka) {
//            //$cenaVunice = $igracka->defaultBoje->bojaVunice->defaultKombinacija->cena_m ?? 0; //ovde prob sa vezama moracu resim
//            //$cenaOciju = $igracka->defaultBoje->bojaOciju->defaultKombinacija->cena_m ?? 0;
//
//            $cenaVunice = 350.00; //ovo jeste fiksno
//            $cenaOciju = 120.00; //najmanja cena kao default
//            $ukupnaCena = $igracka->defaultKombinacija->cena_pravljenja + $cenaVunice + $cenaOciju; //kao da sabira konstantno sa prvom cenom pravljenja
//        }

        //dd($igracke->pluck('ukupna_cena'));

        return view('igracke.index', ['igracke' => $igracke, 'selectedSort' => $sortOption]);
        //return view('igracke.index', ['igracke' => $igracke, 'selectedSort' => $sortOption, 'ukupnaCena' => $ukupnaCena]); //sort option da se ne bi odmah nakon sortiranja refreshovao select
    }

//    public function show($idIgracka)
//    {
//        $igracka = Igracka::with(['defaultBoje.slika', 'defaultKombinacija'])->findOrFail($idIgracka);
//
//        return view('igracka.show', compact('igracka'));
//    }

}
