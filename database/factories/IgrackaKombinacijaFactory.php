<?php

namespace Database\Factories;

use App\Models\IgrackaKombinacija;
use Illuminate\Database\Eloquent\Factories\Factory;

class IgrackaKombinacijaFactory extends Factory
{
    protected $model = IgrackaKombinacija::class;

    public function definition()
    {
        return [
            'idIgrBoje' => $this->faker->numberBetween(1, 18),
            'idDimenzije' => $this->faker->numberBetween(1, 3),
            'cena_pravljenja' => $this->getCenaPravljenja(), // Poziva funkciju koja vraća tačnu cenu
        ];
    }

    private function getCenaPravljenja()
    {
        switch ($this->faker->numberBetween(1, 3)) {
            case 1:
                return 800.00;
            case 2:
                return 1100.00;
            case 3:
                return 1700.00;
            default:
                return 800.00; // Podrazumevana vrednost
        }
    }
}
