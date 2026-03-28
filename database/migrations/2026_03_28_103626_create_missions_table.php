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
            Schema::create('missions', function (Blueprint $table) {
            $table->id();
        
            // Foreign Keys: Linking to other tables
            $table->foreignId('engin_id')->constrained('engins')->onDelete('cascade');
            $table->foreignId('conducteur_id')->constrained('conducteurs')->onDelete('cascade');
        
            // Mission details
            $table->string('destination');
            $table->date('date_mission');
            $table->text('description')->nullable(); // Optional notes
        
            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
