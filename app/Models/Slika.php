<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slika extends Model
{
    use HasFactory;
    protected $table = 'slika';
    protected $primaryKey = 'idSlika';

    // Veza sa MaterijalKombinacija (slika je povezana sa kombinacijama)
    public function kombinacije()
    {
        return $this->hasMany(MaterijalKombinacija::class, 'idSlika', 'idSlika');
    }
}
