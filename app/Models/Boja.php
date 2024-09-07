<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boja extends Model
{
    use HasFactory;
    protected $table = 'boja';
    protected $primaryKey = 'idBoja';


    // Veza sa MaterijalBoja (boja pripada više materijala)
    public function materijalBoje()
    {
        return $this->hasMany(MaterijalBoja::class, 'idBoja', 'idBoja');
    }
}
