<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IgrackaKombinacija;

class IgrackaKombinacijaSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 18) as $idIgrBoje) {
            foreach (range(1, 3) as $idDimenzije) {
                IgrackaKombinacija::factory()->create([
                    'idIgrBoje' => $idIgrBoje,
                    'idDimenzije' => $idDimenzije,
                    'cena_pravljenja' => $this->getCenaZaDimenziju($idDimenzije),
                ]);
            }
        }
    }

    private function getCenaZaDimenziju($idDimenzije)
    {
        switch ($idDimenzije) {
            case 1:
                return 800.00;
            case 2:
                return 1100.00;
            case 3:
                return 1700.00;
            default:
                return 800.00;
        }
    }
}
