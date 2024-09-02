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
        return $this->belongsTo(Boja::class, 'idBoja');
    }

    public function materijal()
    {
        return $this->belongsTo(Materijal::class, 'idMaterijal');
    }

    public function kombinacija()
    {
        return $this->hasMany(MaterijalKombinacija::class, 'idMatBoja');
    }
}
