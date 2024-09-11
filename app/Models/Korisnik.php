<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Korisnik extends Authenticatable
{
    use HasFactory;

    protected $table = 'korisnik';
    protected $primaryKey = 'idKorisnik';

    // Definiši koje atribute možeš masovno puniti (mass-assignable)
    protected $fillable = [
        'ime', 'prezime', 'mejl', 'kor_ime', 'lozinka', 'adresa_kor', 'idTipKor'
    ];

    // Sakrij polja poput lozinke prilikom serializacije
    protected $hidden = [
        'lozinka', 'remember_token',
    ];

    // Laravel očekuje da se kolona za lozinku zove 'password', pa moraš ovo dodati
    public function getAuthPassword()
    {
        return $this->lozinka;
    }

    // Definiši accessor za ime kolone ID ako je potrebno
    public function getAuthIdentifierName(): string
    {
        return 'idKorisnik'; // Ovde definišemo da se koristi 'idKorisnik' umesto 'id'
    }

    // Laravel koristi ovu metodu za dobijanje ID-a korisnika
    public function getAuthIdentifier()
    {
        return $this->idKorisnik;
    }

    public function getTipKor(){
        return $this->idTipKor;
    }


    public function tip()
    {
        return $this->belongsTo(TipKorisnika::class, 'idTipKor');
    }

    // Make sure to hash passwords
    public function setPasswordAttribute($value)
    {
        $this->attributes['lozinka'] = bcrypt($value);
    }
}
