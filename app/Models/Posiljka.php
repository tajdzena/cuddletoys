<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posiljka extends Model
{
    use HasFactory;

    protected $table = 'posiljka';
    protected $primaryKey = 'idPosiljka';

    protected $fillable = ['adresa_placanja',
                            'adresa_isporuke',
                            'status_posiljke',
                            'vreme_statusa',
                            'idKorisnik',
                            'ime_p',
                            'prezime_p',
                            'mejl_p',
                            'telefon_p'];


    // Veza sa modelom Korisnik
    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class, 'idKorisnik');
    }

    // Veza sa modelom Racun
    public function racun()
    {
        return $this->hasOne(Racun::class, 'idPosiljka', 'idPosiljka');
    }
}
