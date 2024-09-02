<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SesijaController extends Controller{
    public function prijava(){
        return view('korisnici.prijava');
    }

    public function mojNalog(){
        return view('korisnici.nalog');
    }

    public function odjava(){
        //
    }
}
