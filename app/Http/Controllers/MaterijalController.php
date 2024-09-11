<?php

namespace App\Http\Controllers;

use App\Models\Materijal;
use App\Models\MaterijalBoja;
use App\Models\MaterijalKombinacija;
use Illuminate\Http\Request;

class MaterijalController extends Controller
{
    public function index(Request $request)
    {
        // Prikaz svih materijala

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
                $query = $query->orderBy('idMaterijal', 'desc');
                break;
            default:
                $query = $query->orderBy('naziv_m', 'asc');  // Default sortiranje
        }

        // Dohvati sve materijale sa primenjenim sortiranjem
        //$materijali = $query->get();

        $materijali = $query->paginate(8);

        $materijali->appends(['sort' => $sortOption]);
        return view('materijali.index', ['materijali' => $materijali, 'selectedSort' => $sortOption]);
    }

    public function show($id)
    {
        // Prikaz pojedinačnog materijala
        $materijal = Materijal::with([
            'defaultKombinacija.slika',
            'boje.boja',
            'kombinacije.dimenzija'
        ])->findOrFail($id);

        // Prikupite dostupne boje materijala
        $bojeMaterijala = $materijal->boje->pluck('boja')->unique('idBoja');

        // Prikupite sve dimenzije dostupne za materijal
        $dimenzije = $materijal->kombinacije->map(function ($kombinacija) {
            return [
                'idDimenzije' => $kombinacija->dimenzija->idDimenzije,
                'naziv_d' => $kombinacija->dimenzija->naziv_d,
                'cena_m' => $kombinacija->cena_m,
            ];
        })->unique('idDimenzije');

        // Definišite default dimenziju i boje
        $defaultDimenzija = $dimenzije->first();
        $bojeMaterijala = $materijal->kombinacije->where('idDimenzije', $defaultDimenzija['idDimenzije'])
            ->map(function ($kombinacija) {
                return $kombinacija->materijalBoja->boja;
            })->unique('idBoja');

        // Default boja materijala
        $defaultBojaMaterijala = $bojeMaterijala->first()->naziv_b ?? 'default';

        return view('materijali.show',
            compact('materijal', 'bojeMaterijala', 'dimenzije', 'defaultBojaMaterijala', 'defaultDimenzija'));
    }


    public function getBojeByDimenzija($idDimenzije)
    {
        $boje = MaterijalKombinacija::where('idDimenzije', $idDimenzije)
            ->with('materijalBoja.boja')
            ->get()
            ->pluck('materijalBoja.boja')
            ->unique('idBoja');

        return response()->json(['boje' => $boje]);
    }


    public function getMaterijalKombinacija(){
        $idMaterijal = request()->input('idMaterijal');
        $idBoja = request()->input('idBoja');
        $idDimenzije = request()->input('idDimenzije');

        $materijal = Materijal::find($idMaterijal);

        if (!$materijal) {
            return response()->json(['error' => 'Materijal nije pronađen'], 403);
        }

        $materijalBoja = MaterijalBoja::where('idBoja', '=', $idBoja)
            ->where('idMaterijal', '=', $idMaterijal)
            ->first();

        $materijalKombinacija = MaterijalKombinacija::where('idMatBoja', '=', $materijalBoja->idMatBoja)
            ->where('idDimenzije', '=', $idDimenzije)
            ->first();

        // Proveri da li si pronašao kombinaciju sa dimenzijama
        if (!$materijalKombinacija) {
            return response()->json(['error' => 'Kombinacija nije pronađena'], 405);
        }

        return response()->json([
            'idMatKomb' => $materijalKombinacija->idMatKomb,
        ]);
    }


    public function edit($id){

        $materijal = Materijal::find($id);
        $materijalNaziv = $materijal->naziv_m;
        $materijalOpis = $materijal->opis_m;

        return view('materijali.edit', compact('materijal', 'materijalNaziv', 'materijalOpis'));
    }

    public function update($id){

        $attributes = request()->validate([
            'naziv' => ['required']
        ]);

        $naziv = $attributes['naziv'];
        $opis = request()->input('opis');

        $materijal = Materijal::find($id);

        $materijal->naziv_m = $naziv;
        $materijal->opis_m = $opis;

        $materijal->save();

        return redirect()->route('materijali.show', ['id' => $id]);
    }


    public function delete($id){

        $materijal = Materijal::find($id);
        dd($materijal->naziv_m . ' je obrisan/a!');

        $materijal->delete();

        return redirect()->route('materijali.index');
    }
}
