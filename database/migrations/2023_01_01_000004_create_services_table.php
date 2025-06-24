<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('ID_Service');
            $table->foreignId('ID_Entreprise')->constrained('entreprises', 'ID_Entreprise')->cascadeOnDelete();
            $table->string('Nom');
            $table->text('Descriptions')->nullable();
            $table->string('Photos')->nullable();
            $table->boolean('Etat')->default(true);
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
        Schema::dropIfExists('services');
    }
}