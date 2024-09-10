<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogProdaje extends Model
{
    use HasFactory;

    protected $table = 'log_prodaje';
    protected $primaryKey = 'idLogProdaje';
    protected $fillable = ['idKorisnik', 'idMatKomb', 'idIgrKomb', 'idRacun'];

    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class, 'idKorisnik');
    }

    public function posiljka()
    {
        return $this->belongsTo(Posiljka::class, 'idPosiljka');
    }

    public function igrackaKombinacija(){
        return $this->belongsTo(IgrackaKombinacija::class, 'idIgrKomb');
    }

    public function materijalKombinacija(){
        return $this->belongsTo(MaterijalKombinacija::class, 'idMatKomb');
    }

    public function racun(){
        return $this->belongsTo(Racun::class, 'idRacun');
    }

//    public function igracka()
//    {
//        return $this->belongsTo(Igracka::class, 'idIgracka');
//    }
//
//    public function materijal()
//    {
//        return $this->belongsTo(Materijal::class, 'idMaterijal');
//    }
}
