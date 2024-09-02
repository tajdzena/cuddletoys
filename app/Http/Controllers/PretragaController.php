<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\Materijal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PretragaController extends Controller{

    public function index(Request $request)
    {
        //return view('pretraga.index');

        $sortOption = $request->input('sort');
        $searchTerm = $request->input('search');

        // Upit za igračke sa pretragom
        $igrackeQuery = Igracka::with(['defaultBoje.slika', 'defaultKombinacija' => function ($query) {
            $query->orderBy('cena_pravljenja', 'asc');
        }])
            ->where('naziv_i', 'LIKE', "%{$searchTerm}%");

        // Upit za materijale sa pretragom
        $materijaliQuery = Materijal::with(['defaultKombinacija' => function ($query) {
            $query->orderBy('cena_m', 'asc');
        }])
            ->where('naziv_m', 'LIKE', "%{$searchTerm}%");

        // Logika za sortiranje
        // popraviti: sortiranje da se vrsi nad svim materijalima, ne zasebno!!!
        switch ($sortOption) {
            case '1': // Cena rastuće
                $igrackeQuery->select('igracka.idIgracka', 'igracka.naziv_i')
                    ->join('igracka_boje', 'igracka.idIgracka', '=', 'igracka_boje.idIgracka')
                    ->join('igracka_kombinacija', 'igracka_boje.idIgrBoje', '=', 'igracka_kombinacija.idIgrBoje')
                    ->groupBy('igracka.idIgracka', 'igracka.naziv_i')
                    ->orderBy('igracka_kombinacija.cena_pravljenja', 'asc');

                $materijaliQuery->select('materijal.idMaterijal', 'materijal.naziv_m')
                    ->join('materijal_boja', 'materijal.idMaterijal', '=', 'materijal_boja.idMaterijal')
                    ->join('materijal_kombinacija', 'materijal_boja.idMatBoja', '=', 'materijal_kombinacija.idMatBoja')
                    ->groupBy('materijal.idMaterijal', 'materijal.naziv_m')
                    ->orderBy('materijal_kombinacija.cena_m', 'asc');
                break;
            case '2': // Cena opadajuće
                $igrackeQuery->select('igracka.idIgracka', 'igracka.naziv_i')
                    ->join('igracka_boje', 'igracka.idIgracka', '=', 'igracka_boje.idIgracka')
                    ->join('igracka_kombinacija', 'igracka_boje.idIgrBoje', '=', 'igracka_kombinacija.idIgrBoje')
                    ->groupBy('igracka.idIgracka', 'igracka.naziv_i')
                    ->orderBy('igracka_kombinacija.cena_pravljenja', 'desc');

                $materijaliQuery->select('materijal.idMaterijal', 'materijal.naziv_m')
                    ->join('materijal_boja', 'materijal.idMaterijal', '=', 'materijal_boja.idMaterijal')
                    ->join('materijal_kombinacija', 'materijal_boja.idMatBoja', '=', 'materijal_kombinacija.idMatBoja')
                    ->groupBy('materijal.idMaterijal', 'materijal.naziv_m')
                    ->orderBy('materijal_kombinacija.cena_m', 'desc');
                break;
            case '3': // Naziv A-Š
                $igrackeQuery->orderBy('naziv_i', 'asc');
                $materijaliQuery->orderBy('naziv_m', 'asc');
                break;
            case '4': // Naziv Š-A
                $igrackeQuery->orderBy('naziv_i', 'desc');
                $materijaliQuery->orderBy('naziv_m', 'desc');
                break;
            case '5': // Najnoviji
                $igrackeQuery->latest();
                $materijaliQuery->latest();
                break;
            default: // Default sortiranje po nazivu
                $igrackeQuery->orderBy('naziv_i', 'asc');
                $materijaliQuery->orderBy('naziv_m', 'asc');
        }

        $igracke = $igrackeQuery->get();
        $materijali = $materijaliQuery->get();

        // Kombinovanje rezultata igračaka i materijala u zajedničku kolekciju
        $combined = $igracke->concat($materijali);

        // Kreiranje paginacije za kombinovane rezultate
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, $combined->count(), $perPage);
        $paginatedItems->setPath($request->url());

        return view('pretraga.index', [
            'results' => $paginatedItems,
            'searchTerm' => $searchTerm,
            'selectedSort' => $sortOption
        ]);
    }
}
