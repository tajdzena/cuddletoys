<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\Materijal;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PretragaController extends Controller
{
    public function index(Request $request)
    {
        $sortOption = $request->input('sort');
        $searchTerm = $request->input('search');

        // Upit za igračke sa pretragom
        $igrackeQuery = Igracka::with(['defaultBoje.slika', 'defaultKombinacija' => function ($query) {
            $query->orderBy('cena_pravljenja', 'asc');
        }])
            ->where('naziv_i', 'LIKE', "%{$searchTerm}%")
            ->get();

        // Upit za materijale sa pretragom
        $materijaliQuery = Materijal::with(['defaultKombinacija' => function ($query) {
            $query->orderBy('cena_m', 'asc');
        }])
            ->where('naziv_m', 'LIKE', "%{$searchTerm}%")
            ->get();

        // Kombinovanje rezultata igračaka i materijala u zajedničku kolekciju
        $combined = $igrackeQuery->concat($materijaliQuery);

        // Logika za sortiranje u PHP-u
        switch ($sortOption) {
            case '1': // Cena rastuće
                $combined = $combined->sortBy(function ($item) {
                    if ($item instanceof Igracka) {
                        return $item->defaultKombinacija->cena_pravljenja ?? PHP_INT_MAX;
                    } elseif ($item instanceof Materijal) {
                        return $item->defaultKombinacija->cena_m ?? PHP_INT_MAX;
                    }
                    return PHP_INT_MAX;
                });
                break;
            case '2': // Cena opadajuće
                $combined = $combined->sortByDesc(function ($item) {
                    if ($item instanceof Igracka) {
                        return $item->defaultKombinacija->cena_pravljenja ?? PHP_INT_MIN;
                    } elseif ($item instanceof Materijal) {
                        return $item->defaultKombinacija->cena_m ?? PHP_INT_MIN;
                    }
                    return PHP_INT_MIN;
                });
                break;
            case '3': // Naziv A-Š
                $combined = $combined->sortBy(function ($item) {
                    return $item->naziv_i ?? $item->naziv_m;
                });
                break;
            case '4': // Naziv Š-A
                $combined = $combined->sortByDesc(function ($item) {
                    return $item->naziv_i ?? $item->naziv_m;
                });
                break;
            case '5': // Najnoviji
                $combined = $combined->sortByDesc('created_at');
                break;
            default: // Default sortiranje po nazivu
                $combined = $combined->sortBy(function ($item) {
                    return $item->naziv_i ?? $item->naziv_m;
                });
        }

        // Izračunaj ukupnu cenu za svaku igračku
        foreach ($combined as $item) {
            if($item instanceof \App\Models\Igracka){
                $cenaVunice = optional($item->defaultBoje->bojaVunice->defaultKombinacija)->cena_m ?? 0;
                $cenaOciju = optional($item->defaultBoje->bojaOciju->defaultKombinacija)->cena_m ?? 0;
                $item->ukupnaCena = $item->defaultKombinacija->cena_pravljenja + $cenaVunice + $cenaOciju;
            }
        }

        // Kreiranje paginacije za kombinovane rezultate
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 8;
        $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentItems, $combined->count(), $perPage);
        $paginatedItems->setPath($request->url())->appends([
            'sort' => $sortOption,
            'search' => $searchTerm
        ]);

        return view('pretraga.index', [
            'results' => $paginatedItems,
            'searchTerm' => $searchTerm,
            'selectedSort' => $sortOption
        ]);
    }
}
