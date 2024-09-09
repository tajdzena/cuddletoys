<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StavkaKorpe extends Model
{
    use HasFactory;

    protected $table = 'stavka_korpe';
    protected $primaryKey = 'idStavka';

    protected $fillable = ['idIgrKomb', 'idMatKomb', 'idKorpa', 'kolicina_s', 'nacin_pravljenja'];

    public function korpa()
    {
        return $this->belongsTo(Korpa::class, 'idKorpa');
    }

    public function materijal()
    {
        return $this->belongsTo(MaterijalKombinacija::class, 'idMatKomb');
    }

    public function igracka()
    {
        return $this->belongsTo(IgrackaKombinacija::class, 'idIgrKomb');
    }
}
