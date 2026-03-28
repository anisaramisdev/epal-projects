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
    Schema::table('missions', function (Blueprint $table) {
        $table->string('shift')->after('id'); // Matin, Après-midi, Nuit
        $table->string('zone')->after('shift'); // Nord, Centre, Sud
    });

    Schema::table('conducteurs', function (Blueprint $table) {
        $table->dropColumn('telephone'); // Removing personal phone numbers
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
