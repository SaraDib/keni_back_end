<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipe;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipe = [
            // Profession Gestion
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Jean Dupont',
                'NomAR' => 'جان دوبونت',
                'Profession' => 'gestion',
                'ProfessionAR' => 'إدارة',
                'Description' => 'Expert en gestion de centres de santé avec plus de 15 ans d\'expérience.',
                'DescriptionAR' => 'خبير في إدارة المراكز الصحية مع أكثر من 15 عاماً من الخبرة.',
                'Image' => null,
            ],
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Marie Laurent',
                'NomAR' => 'ماري لوران',
                'Profession' => 'gestion',
                'ProfessionAR' => 'إدارة',
                'Description' => 'Spécialiste en organisation et planification administrative.',
                'DescriptionAR' => 'متخصصة في التنظيم والتخطيط الإداري.',
                'Image' => null,
            ],
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Sophie Martin',
                'NomAR' => 'صوفي مارتن',
                'Profession' => 'gestion',
                'ProfessionAR' => 'إدارة',
                'Description' => 'Assure la coordination fluide entre les différents départements.',
                'DescriptionAR' => 'تضمن التنسيق السلس بين الإدارات المختلفة.',
                'Image' => null,
            ],

            // Profession Médical
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Dr. Ahmed Alami',
                'NomAR' => 'د. أحمد العلمي',
                'Profession' => 'medical',
                'ProfessionAR' => 'طبي',
                'Description' => 'Spécialiste renommé en médecine physique et réadaptation.',
                'DescriptionAR' => 'أخصائي مشهور في الطب الفيزيائي وإعادة التأهيل.',
                'Image' => null,
            ],
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Yassine Benani',
                'NomAR' => 'ياسين بناني',
                'Profession' => 'medical',
                'ProfessionAR' => 'طبي',
                'Description' => 'Expert en thérapie manuelle et rééducation sportive.',
                'DescriptionAR' => 'خبير في العلاج اليدوي وإعادة التأهيل الرياضي.',
                'Image' => null,
            ],
            [
                'ID_Entreprise' => 1,
                'Nom' => 'Laila Mansouri',
                'NomAR' => 'ليلى منصوري',
                'Profession' => 'medical',
                'ProfessionAR' => 'طبي',
                'Description' => 'Infirmière Spécialisée',
                'DescriptionAR' => 'ممرضة متخصصة',
                'Image' => null,
            ],
        ];

        foreach ($equipe as $membre) {
            Equipe::create($membre);
        }
    }
}
