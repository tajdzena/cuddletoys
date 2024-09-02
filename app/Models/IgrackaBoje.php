<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgrackaBoje extends Model
{
    use HasFactory;

    protected $table = 'igracka_boje';
    protected $primaryKey = 'idIgrBoje';

    public function igracka()
    {
        return $this->belongsTo(Igracka::class, 'idIgracka');
    }

    public function slika()
    {
        return $this->belongsTo(Slika::class, 'idSlika');
    }

    public function bojaVunice()
    {
        return $this->belongsTo(MaterijalBoja::class, 'idBojaVunice');
    }

    public function bojaOciju()
    {
        return $this->belongsTo(MaterijalBoja::class, 'idBojaOciju');
    }

    public function kombinacije()
    {
        return $this->hasMany(IgrackaKombinacija::class, 'idIgrBoje');
    }
}
