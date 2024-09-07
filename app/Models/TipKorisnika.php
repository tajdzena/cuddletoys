<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipKorisnika extends Model
{
    use HasFactory;

    protected $table = 'tip_korisnika';
    protected $primaryKey = 'idTipKor';

    public function korisnici()
    {
        return $this->hasMany(Korisnik::class, 'idTipKor');
    }
}
