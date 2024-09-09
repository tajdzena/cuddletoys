<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korpa extends Model
{
    use HasFactory;

    protected $table = 'korpa';
    protected $primaryKey = 'idKorpa';

    protected $fillable = ['idKorisnik'];

    public function stavke()
    {
        return $this->hasMany(StavkaKorpe::class, 'idKorpa');
    }

    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class, 'idKorisnik');
    }
}
