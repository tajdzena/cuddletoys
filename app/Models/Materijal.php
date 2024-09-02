<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materijal extends Model
{
    use HasFactory;

    protected $table = 'materijal';
    protected $primaryKey = 'idMaterijal';

//    public function defaultBoja()
//    {
//        return $this->hasOne(MaterijalBoje::class, 'idMaterijal')->where('default', true);
//    }

    public function defaultKombinacija()
    {
        return $this->hasOneThrough(MaterijalKombinacija::class, MaterijalBoja::class, 'idMaterijal', 'idMatBoja')
            ->where('default', true)
            ->orderBy('cena_m', 'asc');
    }
}
