<?php

namespace App\Policies;

use App\Models\Korisnik;

class KorisnikPolicy
{
    public function isAdmin(Korisnik $korisnik)
    {
        return $korisnik->idTipKor === 1; // admin
    }

    public function isModerator(Korisnik $korisnik)
    {
        return $korisnik->idTipKor === 4;
    }

    public function isKurir(Korisnik $korisnik)
    {
        return $korisnik->idTipKor === 3;
    }


    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
