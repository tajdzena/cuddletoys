<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimenzije extends Model
{
    use HasFactory;

    protected $table = 'dimenzije';
    protected $primaryKey = 'idDimenzije';

    public function kombinacije(){
        return $this->hasMany(IgrackaKombinacija::class, 'idDimenzije');
    }

    public function matKombinacije(){
        return $this->hasMany(MaterijalKombinacija::class, 'idDimenzije');
    }

}
