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
        Schema::create('materijal_kombinacija', function (Blueprint $table) {
            $table->id('idMatKomb');
            $table->foreignId('idMatBoja')->constrained('materijal_boja', 'idMatBoja')->cascadeOnDelete();
            $table->foreignId('idDimenzije')->constrained('dimenzije', 'idDimenzije')->cascadeOnDelete();
            $table->foreignId('idSlika')->constrained('slika', 'idSlika')->cascadeOnDelete();
            $table->float('cena_m');
            $table->integer('kolicina_m');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materijal_kombinacija');
    }
};
