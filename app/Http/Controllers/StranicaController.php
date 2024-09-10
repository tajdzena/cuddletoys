<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\Materijal;
use Illuminate\Http\Request;

class StranicaController extends Controller{

    public function pocetna(){
        $najnovijeIgracke = Igracka::orderBy('idIgracka', 'desc')->with(['defaultBoje.slika', 'defaultKombinacija'])->take(4)->get();
        $najnovijiMaterijali = Materijal::orderBy('idMaterijal', 'desc')->with(['defaultKombinacija'])->take(4)->get();

        foreach ($najnovijeIgracke as $igracka) {
            $cenaVunice = optional($igracka->defaultBoje->bojaVunice->defaultKombinacija)->cena_m ?? 0;
            $cenaOciju = optional($igracka->defaultBoje->bojaOciju->defaultKombinacija)->cena_m ?? 0;
            $igracka->ukupnaCena = $igracka->defaultKombinacija->cena_pravljenja + $cenaVunice + $cenaOciju;
        }

        return view('index', [
            'najnovijeIgracke' => $najnovijeIgracke,
            'najnovijiMaterijali' => $najnovijiMaterijali,
        ]);
    }

    public function tutorijali(){

        $igracke = Igracka::all();

        return view('staticne.tutorijali', compact('igracke'));
    }

    public function kontakt(){
        return view('staticne.kontakt');
    }

    public function oNama(){
        return view('staticne.onama');
    }
}


