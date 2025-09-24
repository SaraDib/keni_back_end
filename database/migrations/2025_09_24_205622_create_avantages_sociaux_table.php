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
        Schema::create('avantages_sociaux', function (Blueprint $table) {
            $table->id();
            $table->string('photo'); // Chemin vers l'image de l'avantage
            $table->text('paragraphe'); // Description de l'avantage social
            $table->timestamps();
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avantages_sociaux');
    }
};
