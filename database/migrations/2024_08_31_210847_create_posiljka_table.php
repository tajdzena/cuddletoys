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
        Schema::create('posiljka', function (Blueprint $table) {
            $table->id('idPosiljka');
            $table->string('adresa_placanja');
            $table->string('adresa_isporuke');
            $table->string('status_posiljke');
            $table->timestamp('vreme_statusa');
            $table->foreignId('idKorisnik')->constrained('korisnik', 'idKorisnik')->cascadeOnDelete();
            $table->string('ime_p');
            $table->string('prezime_p');
            $table->string('mejl_p');
            $table->string('telefon_p');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posiljka');
    }
};
