<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterijalKombinacija extends Model
{
    use HasFactory;

    protected $table = 'materijal_kombinacija';
    protected $primaryKey = 'idMatKomb';

    public $timestamps = false; // Ako ne koristite timestamps kolone

    protected $fillable = [
        'idMatBoja',
        'idDimenzije',
        'cena_m',
        'kolicina_m',
        'idSlika'
    ];


    public function dimenzija()
    {
        return $this->belongsTo(Dimenzije::class, 'idDimenzije');
    }

    public function boja()
    {
        return $this->belongsTo(MaterijalBoja::class, 'idMatBoja');
    }

    public function slika(){
        return $this->belongsTo(Slika::class, 'idSlika');
    }
}
