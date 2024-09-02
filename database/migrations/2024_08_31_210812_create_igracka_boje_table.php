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
        Schema::create('igracka_boje', function (Blueprint $table) {
            $table->id('idIgrBoje');
            $table->foreignId('idIgracka')->constrained('igracka', 'idIgracka')->cascadeOnDelete();
            $table->foreignId('idBojaVunice')->constrained('materijal_boja', 'idMatBoja')->cascadeOnDelete();
            //provera da li je u pitanju vunica kasnije i isto za oci
            $table->foreignId('idBojaOciju')->constrained('materijal_boja', 'idMatBoja')->cascadeOnDelete();
            $table->foreignId('idSlika')->constrained('slika', 'idSlika')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('igracka_boje');
    }
};
