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
        Schema::table('log_prodaje', function (Blueprint $table) {
            //$table->foreignId('idRacun')->constrained('racun', 'idRacun'); //->cascadeOnDelete();

            // Ukloni postojeći strani ključ
            $table->dropForeign(['idRacun']);

            // Ponovo kreiraj strani ključ sa onDelete('cascade')
            $table->foreign('idRacun')
                ->references('idRacun')
                ->on('racun')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_prodaje', function (Blueprint $table) {
            // Vrati originalni strani ključ ako je potrebno
            $table->dropForeign(['idRacun']);

            // Ponovo dodaj strani ključ bez onDelete('cascade')
            $table->foreign('idRacun')
                ->references('idRacun')
                ->on('racun')
                ->onDelete('no action');
        });
    }
};
