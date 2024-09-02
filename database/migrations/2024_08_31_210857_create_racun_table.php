<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('racun', function (Blueprint $table) {
            $table->id('idRacun');
            $table->foreignId('idMetodPlacanja')->constrained('metod_placanja', 'idMetodPlacanja');
            $table->foreignId('idPosiljka')->constrained('posiljka', 'idPosiljka')->cascadeOnDelete();
            $table->timestamp('datum_vreme_izdavanjaR');
            $table->timestamp('datum_vreme_placanja')->nullable()->default(null); //sem ako se placa karticom
            $table->float('iznos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('racun');
    }
};
