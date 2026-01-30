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
        Schema::table('centres', function (Blueprint $table) {
            if (!Schema::hasColumn('centres', 'NomAR')) {
                $table->string('NomAR')->nullable()->after('Nom');
            }
            if (!Schema::hasColumn('centres', 'AdresseAR')) {
                $table->string('AdresseAR')->nullable()->after('Adresse');
            }
            if (!Schema::hasColumn('centres', 'Positions')) {
                $table->string('Positions')->nullable()->after('Handicapes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centres', function (Blueprint $table) {
            $table->dropColumn(['NomAR', 'AdresseAR', 'Positions']);
        });
    }
};
