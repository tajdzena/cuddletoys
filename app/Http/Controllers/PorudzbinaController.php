<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PorudzbinaController extends Controller{
    public function korpa(){
        return view('porudzbine.korpa');
    }

    public function porudzbina(){
        return view('porudzbine.porudzbina');
    }

    public function racun(){
        return view('porudzbine.racun');
    }
}
