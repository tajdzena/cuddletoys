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
        // Definiši sortiranje
        $sortOption = $request->input('sort');

        // Upit osnovni pre selecta, da znamo na koji način prikazujemo čim se učita stranica
        $query = Igracka::with(['defaultBoje.slika', 'defaultKombinacija' => function($query) {
            $query->orderBy('cena_pravljenja', 'asc');
        }]);

        switch ($sortOption) {
            case '1':
                $query = Igracka::select('igracka.idIgracka', 'igracka.naziv_i') // Umesto select * jer onda svaki atribut mora biti u groupBy
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
                $query = $query->orderBy('idIgracka', 'desc');  // Sortiranje po najnovijim, sto veci id to su novije jer se inkrementira, nemaju sve created_at
                break;
            default:
                $query = $query->orderBy('naziv_i', 'asc');  // Default sortiranje
        }


        // Dohvatanje igračaka i paginacija sa 8 rezultata po stranici
        $igracke = $query->paginate(8);

        // Ukupna cena za svaku igračku
        foreach ($igracke as $igracka) {
            $cenaVunice = optional($igracka->defaultBoje->bojaVunice->defaultKombinacija)->cena_m ?? 0;
            $cenaOciju = optional($igracka->defaultBoje->bojaOciju->defaultKombinacija)->cena_m ?? 0;
            $igracka->ukupnaCena = $igracka->defaultKombinacija->cena_pravljenja + $cenaVunice + $cenaOciju;
        }

        $igracke->appends(['sort' => $sortOption]); // Da se sortiranje prebaci i na druge strane
        return view('igracke.index', ['igracke' => $igracke, 'selectedSort' => $sortOption]);
        // sortOption da se ne bi odmah nakon sortiranja refreshovao select
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


        // Prikupiti dostupne boje vunice i očiju za igracku
        $bojeVunice = $igracka->boje->pluck('bojaVunice')->unique('idBoja');
        $bojeOciju = $igracka->boje->pluck('bojaOciju')->unique('idBoja');

        // Prikupiti sve dimenzije dostupne za igračku zajedno sa cenom iz kombinacija
        $dimenzije = $igracka->kombinacije->map(function ($kombinacija) {
            return [
                'idDimenzije' => $kombinacija->dimenzija->idDimenzije,
                'naziv_d' => $kombinacija->dimenzija->naziv_d,
                'cena_pravljenja' => $kombinacija->cena_pravljenja,
            ];
        })->unique('idDimenzije');

        // Definisanje defaultne boje za igracku
        $defaultBojaVunice = $bojeVunice->first()->boja->naziv_b ?? 'Ne postoji default boja vunice';
        if($defaultBojaVunice == 'žuta'){
            $defaultBojaVunice = 'zuta';
        } // PHP ne voli srpski :)
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


        // Proveri da li si pronašao boje za igračku
        if (!$igrackaBoje) {
            return response()->json(['error' => 'Boje za igračku nisu pronađene'], 402);
        }

        $igrackaKombinacija = IgrackaKombinacija::where('idIgrBoje', '=', $igrackaBoje->idIgrBoje)
            ->where('idDimenzije', '=', $idDimenzije)
            ->first();


        // Proveri da li si pronašao kombinaciju sa dimenzijama
        if (!$igrackaKombinacija) {
            return response()->json(['error' => 'Kombinacija nije pronađena'], 405);
        }

        return response()->json([
            'idIgrKomb' => $igrackaKombinacija->idIgrKomb,
        ]);
    }


    public function edit($id){

        $igracka = Igracka::find($id);
        $igrackaNaziv = $igracka->naziv_i;
        $igrackaOpis = $igracka->opis_i;

        return view('igracke.edit', compact('igracka', 'igrackaNaziv', 'igrackaOpis'));
    }

    public function update($id){

        $attributes = request()->validate([
            'naziv' => ['required']
        ]);

        $naziv = $attributes['naziv'];
        $opis = request()->input('opis');

        $igracka = Igracka::find($id);

        $igracka->naziv_i = $naziv;
        $igracka->opis_i = $opis;

        $igracka->save();

        return redirect()->route('igracke.show', ['id' => $id]);
    }


    public function delete($id){

        $igracka = Igracka::find($id);
        dd($igracka->naziv_i . ' je obrisan/a!');

        $igracka->delete();

        return redirect()->route('igracke.index');
    }

}
