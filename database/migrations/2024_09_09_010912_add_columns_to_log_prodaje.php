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
            $table->foreignId('idMatKomb')->nullable()->constrained('materijal_kombinacija', 'idMatKomb');
            $table->foreignId('idIgrKomb')->nullable()->constrained('igracka_kombinacija', 'idIgrKomb');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_prodaje', function (Blueprint $table) {
            $table->dropColumn('idMatKomb');
            $table->dropColumn('idIgrKomb');
        });
    }
};
