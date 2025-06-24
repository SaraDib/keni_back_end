<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('centres', function (Blueprint $table) {
            $table->id('ID_Center');
            $table->foreignId('ID_Entreprise')->constrained('entreprises', 'ID_Entreprise')->cascadeOnDelete();
            $table->string('Nom');
            $table->string('Adresse')->nullable();
            $table->string('Telephone')->nullable();
            $table->string('Fix')->nullable();
            $table->string('Email')->nullable();
            $table->boolean('Handicapes')->default(false);
            $table->string('Positions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centres');
    }
}