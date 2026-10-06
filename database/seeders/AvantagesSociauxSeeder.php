<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AvantagesSociaux;

class AvantagesSociauxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table avant de seeder
        DB::table('avantages_sociaux')->truncate();

        $avantages = [
            [
                'photo' => 'avantages/assurances.jpg', // Assurez-vous que cette image existe ou adaptez le chemin
                'paragraphe' => 'Une assurance santé complète pour vous et votre famille, incluant les soins dentaires et visuels.',
            ],
            [
                'photo' => 'avantages/formation.jpg',
                'paragraphe' => 'Accès à des programmes de formation continue et de développement professionnel pour faire évoluer votre carrière.',
            ],
            [
                'photo' => 'avantages/flexibilite.jpg',
                'paragraphe' => 'Horaires de travail flexibles et possibilité de télétravail pour un meilleur équilibre vie pro-vie perso.',
            ],
            [
                'photo' => 'avantages/primes.jpg',
                'paragraphe' => 'Primes de performance annuelles et avantages financiers attractifs basés sur les résultats.',
            ],
            [
                'photo' => 'avantages/bien-etre.jpg',
                'paragraphe' => 'Programmes de bien-être au travail, incluant des séances de sport et des activités de team building.',
            ],
        ];

        foreach ($avantages as $avantage) {
            AvantagesSociaux::create($avantage);
        }
    }
}
