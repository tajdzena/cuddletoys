<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegistracijaController extends Controller
{
    public function create()
    {
        // Prikaz forme za registraciju
        return view('korisnici.registracija');
    }

    public function store()
    {
        // Validacija korisničkih podataka
        $attributes = request()->validate([
            'ime' => ['required'],
            'prezime' => ['required'],
            'mejl' => ['required', 'email', 'unique:korisnik,mejl'],
            'kor_ime' => ['required', 'unique:korisnik,kor_ime'],
            'lozinka' => ['required', 'confirmed', Password::min(8)
                                                    ->mixedCase() // Bar jedno veliko i malo slovo
                                                    ->numbers() // Bar jedan broj
                                                    ->symbols()], // Bar jedan specijalni znak
            'adresa' => ['nullable'],
        ],
        [
            //prilagodjene poruke o greskama
            'lozinka.min' => 'Lozinka mora imati najmanje 8 karaktera.',
            'lozinka.mixed_case' => 'Lozinka mora sadržati i mala i velika slova.',
            'lozinka.numbers' => 'Lozinka mora sadržati bar jedan broj.',
            'lozinka.symbols' => 'Lozinka mora sadržati bar jedan specijalni znak.',
            'lozinka.confirmed' => 'Lozinke se ne poklapaju.',
        ],
        [
            'kor_ime' => 'korisničko ime', //zbog greske da se ispisuje Polje korisnicko ime mora biti obavezno umesto kor_ime
        ]);


        // Kreiranje novog korisnika
        $korisnik = Korisnik::create([
            'ime' => $attributes['ime'],
            'prezime' => $attributes['prezime'],
            'mejl' => $attributes['mejl'],
            'kor_ime' => $attributes['kor_ime'],
            'lozinka' => Hash::make($attributes['lozinka']),
            'adresa_kor' => $attributes['adresa'] ?? null,
            'idTipKor' => 2, // Postavljanje tipa korisnika (2 za regularne korisnike)
        ]);

        Auth::login($korisnik);

        return redirect('/igracke');
    }
}
