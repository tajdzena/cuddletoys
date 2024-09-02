<?php

namespace App\Http\Controllers;

use App\Models\Materijal;
use Illuminate\Http\Request;

class MaterijalController extends Controller
{
    public function index(Request $request)
    {
        // Prikaz svih materijala
//        $materijali = Materijal::with(['defaultKombinacija'])
//            ->get();
//        return view('materijali.index', ['materijali' => $materijali]);

        $sortOption = $request->input('sort');

        $query = Materijal::with(['defaultKombinacija' => function($query) {
            $query->orderBy('cena_m', 'asc');
        }]);

        switch ($sortOption) {
            case '1':
                $query = Materijal::select('materijal.idMaterijal', 'materijal.naziv_m')
                    ->join('materijal_boja', 'materijal.idMaterijal', '=', 'materijal_boja.idMaterijal')
                    ->join('materijal_kombinacija', 'materijal_boja.idMatBoja', '=', 'materijal_kombinacija.idMatBoja')
                    ->groupBy('materijal.idMaterijal', 'materijal.naziv_m')
                    ->orderBy('materijal_kombinacija.cena_m', 'asc');
                break;
            case '2':
                $query = Materijal::select('materijal.idMaterijal', 'materijal.naziv_m')
                    ->join('materijal_boja', 'materijal.idMaterijal', '=', 'materijal_boja.idMaterijal')
                    ->join('materijal_kombinacija', 'materijal_boja.idMatBoja', '=', 'materijal_kombinacija.idMatBoja')
                    ->groupBy('materijal.idMaterijal', 'materijal.naziv_m')
                    ->orderBy('materijal_kombinacija.cena_m', 'desc');
                break;
            case '3':
                $query = $query->orderBy('naziv_m', 'asc');
                break;
            case '4':
                $query = $query->orderBy('naziv_m', 'desc');
                break;
            case '5':
                $query = $query->latest();  // Sortiranje po najnovijim
                break;
            default:
                $query = $query->orderBy('naziv_m', 'asc');  // Default sortiranje
        }

        // Dohvati sve materijale sa primenjenim sortiranjem
        $materijali = $query->get();


        return view('materijali.index', ['materijali' => $materijali, 'selectedSort' => $sortOption]);
    }

    public function show($id)
    {
//        // Prikaz pojedinačnog materijala
//        $materijal = Materijal::with(['kombinacije.dimenzije', 'kombinacije.slika'])
//            ->findOrFail($id);
//        return view('materijali.show', ['materijal' => $materijal]);
    }
}
