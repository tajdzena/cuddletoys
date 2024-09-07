<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterijalBoja extends Model
{
    use HasFactory;

    protected $table = 'materijal_boja';
    protected $primaryKey = 'idMatBoja';

    public function boja()
    {
        return $this->belongsTo(Boja::class, 'idBoja', 'idBoja');
    }

    public function igrackaVunica(){
        return $this->hasMany(IgrackaBoje::class, 'idBojaVunice', 'idMatBoja');
    }

    public function igrackaOci(){
        return $this->hasMany(IgrackaBoje::class, 'idBojaOciju', 'idMatBoja');
    }

    public function materijal()
    {
        return $this->belongsTo(Materijal::class, 'idMaterijal', 'idMaterijal');
    }

    public function kombinacije()
    {
        return $this->hasMany(MaterijalKombinacija::class, 'idMatBoja', 'idMatBoja');
    }

    public function defaultKombinacija()
    {
        return $this->hasOne(MaterijalKombinacija::class, 'idMatBoja')
            ->where('default', true);;
    }
}
