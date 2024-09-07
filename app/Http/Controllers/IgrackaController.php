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

}
