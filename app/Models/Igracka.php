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
            ->where('default', true);
    }

    public function kombinacije()
    {
        // Promena u ovoj liniji: Povezujemo se na IgrackaKombinacija preko IgrackaBoje
        return $this->hasManyThrough(IgrackaKombinacija::class, IgrackaBoje::class, 'idIgracka', 'idIgrBoje', 'idIgracka', 'idIgrBoje');
    }

}
