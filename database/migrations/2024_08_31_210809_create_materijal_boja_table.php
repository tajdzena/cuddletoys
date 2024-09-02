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
        Schema::create('materijal_boja', function (Blueprint $table) {
            $table->id('idMatBoja');
            $table->foreignId('idMaterijal')->constrained('materijal', 'idMaterijal')->cascadeOnDelete();
            $table->foreignId('idBoja')->constrained('boja', 'idBoja')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materijal_boja');
    }
};
