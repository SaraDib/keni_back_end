<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRendezVousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id('ID_Rendez_Vous');
            $table->foreignId('ID_Entreprise')->constrained('entreprises', 'ID_Entreprise')->cascadeOnDelete();
            $table->string('Nom');
            $table->string('Prenom');
            $table->date('Date_Naissance')->nullable();
            $table->string('Tel')->nullable();
            $table->string('Email')->nullable();
            $table->string('Faire')->nullable();
            $table->string('Type_recette')->nullable();
            $table->integer('nombre')->nullable();
            $table->string('Ergotherapie')->nullable();
            $table->string('Physiotherapie')->nullable();
            $table->text('Remarque')->nullable();
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
        Schema::dropIfExists('rendez_vous');
    }
}