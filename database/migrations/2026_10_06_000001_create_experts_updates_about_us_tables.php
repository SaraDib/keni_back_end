<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tables used by the Expert, Update and AboutUs models that no earlier
 * migration created. Guarded so it is a no-op on databases that already
 * have them (e.g. production, where they were created outside migrations).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('experts')) {
            Schema::create('experts', function (Blueprint $table) {
                $table->id('ID_Expert');
                $table->string('VideoURL')->nullable();
                $table->string('ImagePath')->nullable();
                $table->string('TitleFR')->nullable();
                $table->string('TitleAR')->nullable();
                $table->longText('DescriptionFR')->nullable();
                $table->longText('DescriptionAR')->nullable();
                $table->boolean('Etat')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('updates')) {
            Schema::create('updates', function (Blueprint $table) {
                $table->id('ID_Updates');
                $table->string('image_path')->nullable();
                $table->string('title_fr')->nullable();
                $table->string('title_ar')->nullable();
                $table->longText('description_fr')->nullable();
                $table->longText('description_ar')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('about_us')) {
            Schema::create('about_us', function (Blueprint $table) {
                $table->id();
                $table->longText('description_fr');
                $table->longText('description_ar');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
        Schema::dropIfExists('updates');
        Schema::dropIfExists('experts');
    }
};
