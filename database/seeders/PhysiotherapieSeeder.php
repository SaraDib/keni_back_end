<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Physiotherapie;

class PhysiotherapieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table avant d'insérer les nouvelles données
        Physiotherapie::truncate();

        // Packs et services de physiothérapie
        $packs = [
            [
                'nom' => 'Pack Découverte (3 séances + bilan initial) – Offre limitée : valable pour les 50 premiers clients durant le premier mois d\'ouverture'
            ],
            [
                'nom' => 'Pack Prévention (6 séances – entraînement fonctionnel & suivi santé)'
            ],
            [
                'nom' => 'Pack Santé Globale (5–20 séances : kinésithérapie avec ordonnance + entraînement fonctionnel + bilans de suivi + option massage thérapeutique)'
            ],
            [
                'nom' => 'Pack Famille (programme personnalisé : activités collectives, entraînement adultes/enfants/seniors, bilans familiaux)'
            ],
            [
                'nom' => 'Bilan initial'
            ],
            [
                'nom' => 'Suivi intermédiaire'
            ],
            [
                'nom' => 'Bilan final'
            ]
        ];

        // Insérer les données
        foreach ($packs as $pack) {
            Physiotherapie::create($pack);
        }
    }
}