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
    Schema::create('conducteurs', function (Blueprint $table) {
        $table->id();
        $table->string('nom');           // Name of the driver
        $table->string('prenom');        // First name
        $table->string('telephone');     // Phone number
        $table->string('permis_numero'); // License number (unique)
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conducteurs');
    }
};
