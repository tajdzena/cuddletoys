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
        Schema::create('igracka_kombinacija', function (Blueprint $table) {
            $table->id('idIgrKomb');
            $table->foreignId('idIgrBoje')->constrained('igracka_boje', 'idIgrBoje')->cascadeOnDelete();
            $table->foreignId('idDimenzije')->constrained('dimenzije', 'idDimenzije')->cascadeOnDelete();
            $table->float('cena_pravljenja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('igracka_kombinacija');
    }
};
