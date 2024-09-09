<?php

namespace App\Policies;

use App\Models\Korisnik;

class KorisnikPolicy
{
    public function isAdmin(Korisnik $korisnik)
    {
        return $korisnik->idTipKor === 1; // admin
    }

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
}
