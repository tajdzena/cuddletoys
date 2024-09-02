<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Igracka extends Model
{
    use HasFactory;

    protected $table = 'igracka';
    protected $primaryKey = 'idIgracka';

    public function defaultBoje()
    {
        return $this->hasOne(IgrackaBoje::class, 'idIgracka')->where('default', true);
    }

    public function boje()
    {
        return $this->hasMany(IgrackaBoje::class, 'idIgracka');
    }

    public function defaultKombinacija()
    {
        return $this->hasOneThrough(IgrackaKombinacija::class, IgrackaBoje::class, 'idIgracka', 'idIgrBoje')
            ->orderBy('cena_pravljenja', 'asc');
    }

    public function kombinacije()
    {
        return $this->hasMany(IgrackaKombinacija::class, 'idIgracka');
    }

    //za cenu default kombo igracke moramo videti i cenu tih materijala
    public function defaultVunicaKombinacija()
    {
        return $this->hasOneThrough(
            MaterijalKombinacija::class,
            MaterijalBoja::class,
            'idMatBoja', // Foreign key on MaterijalBoja table
            'idMatBoja', // Foreign key on MaterijalKombinacija table
            'idIgracka', // Local key on Igracka table
            'idBojaVunice' // Local key on MaterijalBoja table
        );
    }

    public function defaultOciKombinacija()
    {
        return $this->hasOneThrough(
            MaterijalKombinacija::class,
            MaterijalBoja::class,
            'idMatBoja', // Foreign key on MaterijalBoja table
            'idMatBoja', // Foreign key on MaterijalKombinacija table
            'idIgracka', // Local key on Igracka table
            'idBojaOciju' // Local key on MaterijalBoja table
        );
    }

}
