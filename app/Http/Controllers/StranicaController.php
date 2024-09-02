<?php

namespace App\Http\Controllers;

use App\Models\Igracka;
use App\Models\Materijal;
use Illuminate\Http\Request;

class StranicaController extends Controller{

    public function pocetna(){
        $najnovijeIgracke = Igracka::latest()->with(['defaultBoje.slika', 'defaultKombinacija'])->take(4)->get();
        $najnovijiMaterijali = Materijal::latest()->with(['defaultKombinacija'])->take(4)->get();
        return view('index', [
            'najnovijeIgracke' => $najnovijeIgracke,
            'najnovijiMaterijali' => $najnovijiMaterijali,
        ]);
    }

    public function tutorijali(){
        return view('staticne.tutorijali');
    }

    public function kontakt(){
        return view('staticne.kontakt');
    }

    public function oNama(){
        return view('staticne.onama');
    }
}


