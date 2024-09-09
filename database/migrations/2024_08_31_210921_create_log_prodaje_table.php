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
        Schema::create('log_prodaje', function (Blueprint $table) {
            $table->id('idLogProdaje');
//            $table->foreignId('idMaterijal')->nullable()->constrained('materijal', 'idMaterijal');
//            $table->foreignId('idIgracka')->nullable()->constrained('igracka', 'idIgracka');
            $table->foreignId('idRacun')->constrained('racun', 'idRacun');
            $table->foreignId('idKorisnik')->constrained('korisnik', 'idKorisnik')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_prodaje');
    }
};
