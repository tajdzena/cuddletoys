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
        Schema::table('posiljka', function (Blueprint $table) {
            $table->string('ime_p');
            $table->string('prezime_p');
            $table->string('mejl_p');
            $table->string('telefon_p');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posiljka', function (Blueprint $table) {
            $table->dropColumn('ime_p');
            $table->dropColumn('prezime_p');
            $table->dropColumn('mejl_p');
            $table->dropColumn('telefon_p');
        });
    }
};
