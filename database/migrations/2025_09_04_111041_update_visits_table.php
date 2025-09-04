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
        Schema::table('visits', function (Blueprint $table) {
            // supprimer la colonne "page"
            $table->dropColumn('page');

            // rendre l'ip unique
            $table->string('ip')->unique()->change();

            // ajouter une colonne "pays"
            $table->string('pays')->nullable()->after('ip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // remettre l'ip en index normal (pas unique)
            $table->dropUnique(['ip']);
            $table->string('ip')->index()->change();

            // rajouter la colonne page
            $table->string('page')->nullable();

            // supprimer la colonne pays
            $table->dropColumn('pays');
        });
    }
};
