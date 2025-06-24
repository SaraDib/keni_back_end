<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horaires', function (Blueprint $table) {
            $table->id('ID_Horaire');
            $table->foreignId('ID_Center')->constrained('centres', 'ID_Center')->cascadeOnDelete();
            $table->string('Day_Start');
            $table->string('Day_End');
            $table->time('Time_Start');
            $table->time('Time_End');
            $table->boolean('isClosed')->default(false);
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
        Schema::dropIfExists('horaires');
    }
}