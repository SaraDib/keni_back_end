<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRowServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('row_services', function (Blueprint $table) {
            $table->id('ID_Row');
            $table->foreignId('ID_Service')->constrained('services', 'ID_Service')->cascadeOnDelete();
            $table->foreignId('ID_Type_Photo')->constrained('type_photos', 'ID_Type_Photo')->cascadeOnDelete();
            $table->text('Text')->nullable();
            $table->integer('Classement')->default(0);
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
        Schema::dropIfExists('row_services');
    }
}