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
        Schema::create('stavka_korpe', function (Blueprint $table) {
            $table->id('idStavka');
            $table->foreignId('idIgrKomb')->nullable()->constrained('igracka_kombinacija', 'idIgrKomb');
            $table->foreignId('idMatKomb')->nullable()->constrained('materijal_kombinacija', 'idMatKomb');
            $table->foreignId('idKorpa')->constrained('korpa', 'idKorpa')->cascadeOnDelete();
            //kad se izbrise idKorpe u Korpa, brise se i ovde stavka koja je vezana za tu korpu
            $table->integer('kolicina_s');
            $table->string('nacin_pravljenja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stavka_korpe');
    }
};
