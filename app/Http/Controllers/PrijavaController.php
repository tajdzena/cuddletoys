<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PrijavaController extends Controller
{
    public function create()
    {
        // Prikaz forme za prijavu
        return view('korisnici.prijava');
    }

    public function store()
    {
        // Validacija prijavnih podataka
        $credentials = request()->validate([
            'mejl_ili_kor_ime' => 'required|string',
            'lozinka' => 'required|string',
        ]);

        // Provera da li korisnik koristi mejl ili korisničko ime za prijavu
        $korisnik = Korisnik::where('mejl', $credentials['mejl_ili_kor_ime'])
            ->orWhere('kor_ime', $credentials['mejl_ili_kor_ime'])
            ->first();

        if ($korisnik && Hash::check($credentials['lozinka'], $korisnik->lozinka)) {
            Auth::login($korisnik);
            //regenerating session token every time user logs in
            //useful against hackers if they get a hold of the token at some point
            request()->session()->regenerate();
            return redirect('/nalog');
        } else {
            return back()->withErrors([
                'mejl_ili_kor_ime' => 'Pogrešni podaci za prijavu.',
            ]);
        }

    }

    public function destroy()
    {
        // Odjava korisnika
        Auth::logout();
        return redirect('/');
    }
}
