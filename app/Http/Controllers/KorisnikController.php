<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KorisnikController extends Controller{

    public function show(){
        return view('korisnici.registracija');
    }
}