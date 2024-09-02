<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgrackaKombinacija extends Model
{
    use HasFactory;

    protected $table = 'igracka_kombinacija';
    protected $primaryKey = 'idIgrKomb';

    public $timestamps = false;

    protected $fillable = [
        'idIgrBoje',
        'idDimenzije',
        'cena_pravljenja',
    ];


    public function dimenzija()
    {
        return $this->belongsTo(Dimenzije::class, 'idDimenzije');
    }

    public function boje()
    {
        return $this->belongsTo(IgrackaBoje::class, 'idIgrBoje');
    }
}
