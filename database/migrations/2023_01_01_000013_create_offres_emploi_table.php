<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffresEmploiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offres_emploi', function (Blueprint $table) {
            $table->id('ID_Offres_Emploi');
            $table->foreignId('ID_Entreprise')->constrained('entreprises', 'ID_Entreprise')->cascadeOnDelete();
            $table->string('Salutation');
            $table->string('Nom');
            $table->string('Rue');
            $table->string('Code_Postal');
            $table->string('Ville');
            $table->string('Email');
            $table->string('Telephone');
            $table->string('Profession');
            $table->text('lettre')->nullable();
            $table->string('CV')->nullable();
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
        Schema::dropIfExists('offres_emploi');
    }
}