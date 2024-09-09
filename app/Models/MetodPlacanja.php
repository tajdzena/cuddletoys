<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodPlacanja extends Model
{
    use HasFactory;

    protected $table = 'metod_placanja';
    protected $primaryKey = 'idMetodPlacanja';

    public function racun()
    {
        return $this->hasMany(Racun::class, 'idMetodPlacanja');
    }
}
