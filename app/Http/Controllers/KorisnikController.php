<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class KorisnikController extends Controller
{
    // Prikaz stranice za profil
    public function nalog()
    {
        $korisnik = Auth::user();
        return view('korisnici.nalog', compact('korisnik'));
    }

    // Izmena podataka korisnika
    public function izmeniPodatke()
    {
        $korisnik = Auth::user();

        $attributes = request()->validate([
            'ime' => ['required'],
            'prezime' => ['required'],
            'mejl' => 'required|email|unique:korisnik,mejl,' . $korisnik->getAuthIdentifier() . ',idKorisnik', //umesto idKorisnik
            'kor_ime' => 'required|unique:korisnik,kor_ime,' . $korisnik->getAuthIdentifier() . ',idKorisnik',
            'adresa' => ['nullable'],
        ]);

        $korisnik->update($attributes);

        return redirect()->back()->with('success', 'Podaci su uspešno ažurirani.');
    }

    // Reset lozinke
    public function resetujLozinku()
    {
        $korisnik = Auth::user();

        request()->validate([
            'trenutna_lozinka' => 'required',
            'nova_lozinka' => ['required', 'confirmed', Password::min(8)
                                                        ->mixedCase() // Bar jedno veliko i malo slovo
                                                        ->numbers() // Bar jedan broj
                                                        ->symbols() // Bar jedan specijalni znak
            ],
        ]);

        if (!Hash::check(request()->trenutna_lozinka, $korisnik->getAuthPassword())) {
            return back()->withErrors(['trenutna_lozinka' => 'Trenutna lozinka nije ispravna.']);
        }

        $korisnik->update(['lozinka' => Hash::make(request()->nova_lozinka)]);

        return redirect()->back()->with('success', 'Lozinka je uspešno resetovana.');
    }
}

