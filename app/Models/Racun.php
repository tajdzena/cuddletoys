<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Racun extends Model
{
    use HasFactory;

    protected $table = 'racun';
    protected $primaryKey = 'idRacun';

    protected $fillable = ['idMetodPlacanja', 'idPosiljka', 'datum_vreme_izdavanjaR', 'datum_vreme_placanja', 'iznos', 'idKorisnik'];

    // Veza sa modelom Posiljka
    public function posiljka()
    {
        return $this->belongsTo(Posiljka::class, 'idPosiljka');
    }

    // Veza sa modelom MetodPlacanja
    public function metodPlacanja()
    {
        return $this->belongsTo(MetodPlacanja::class, 'idMetodPlacanja');
    }


    public function logProdaje()
    {
        return $this->hasMany(LogProdaje::class, 'idRacun', 'idRacun');
    }
}
