<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntrepriseSeeder extends Seeder
{
    /**
     * Crée l'entreprise par défaut (ID 1) dont dépendent les autres seeders
     * et le front-end (ID_Entreprise: 1). Ne fait rien si elle existe déjà.
     */
    public function run(): void
    {
        if (DB::table('entreprises')->where('ID_Entreprise', 1)->exists()) {
            return;
        }

        DB::table('entreprises')->insert([
            'ID_Entreprise' => 1,
            'Nom' => 'Global Health',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
