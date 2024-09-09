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
        Schema::create('korpa', function (Blueprint $table) {
            $table->id('idKorpa');
            $table->foreignId('idKorisnik')->constrained('korisnik', 'idKorisnik')->cascadeOnDelete();
            $table->float('ukupna_cena')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korpa');
    }
};
