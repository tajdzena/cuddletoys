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
        Schema::create('korisnik', function (Blueprint $table) {
            $table->id('idKorisnik');
            $table->foreignId('idTipKor')->constrained('tip_korisnika', 'idTipKor')->cascadeOnDelete(); //referenca na idTipKor u tabeli tip_korisnika
            $table->string('ime');
            $table->string('prezime');
            $table->string('mejl')->unique();
            $table->string('kor_ime')->unique();
            $table->string('lozinka');
            $table->string('adresa_kor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('korisnik');
    }
};
