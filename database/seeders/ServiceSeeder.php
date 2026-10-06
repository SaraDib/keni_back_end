<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\RowService;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Données des services
        $servicesData = [
            [
                'Nom' => 'Physiothérapie',
                'NomAR' => 'العلاج الطبيعي',
                'Descriptions' => 'Traitement des troubles du mouvement et de la fonction par des méthodes physiques.',
                'DescriptionsAR' => 'علاج اضطرابات الحركة والوظيفة من خلال الأساليب الفيزيائية.',
                'rows' => [
                    [
                        'ID_Type_Photo' => 1,
                        'Text' => 'La physiothérapie aide à restaurer le mouvement après une blessure.',
                        'TextAR' => 'يساعد العلاج الطبيعي على استعادة الحركة بعد الإصابة.',
                        'Classement' => 1
                    ],
                    [
                        'ID_Type_Photo' => 2,
                        'Text' => 'Nos experts utilisent des techniques modernes de rééducation.',
                        'TextAR' => 'يستخدم خبراؤنا تقنيات حديثة لإعادة التأهيل.',
                        'Classement' => 2
                    ]
                ]
            ],
            [
                'Nom' => 'Ergothérapie',
                'NomAR' => 'العلاج الوظيفي',
                'Descriptions' => 'Aide à maintenir l\'indépendance dans les activités quotidiennes.',
                'DescriptionsAR' => 'المساعدة في الحفاظ على الاستقلالية في الأنشطة اليومية.',
                'rows' => [
                    [
                        'ID_Type_Photo' => 1,
                        'Text' => 'Adaptation de l\'environnement de travail et du domicile.',
                        'TextAR' => 'تكييف بيئة العمل والمنزل.',
                        'Classement' => 1
                    ],
                    [
                        'ID_Type_Photo' => 1,
                        'Text' => 'Développement des compétences pour l\'autonomie.',
                        'TextAR' => 'تطوير المهارات من أجل الاستقلالية.',
                        'Classement' => 2
                    ]
                ]
            ],
            [
                'Nom' => 'Entraînement fonctionnel',
                'NomAR' => 'التدريب الوظيفي',
                'Descriptions' => 'Exercices conçus pour améliorer la force et la mobilité utiles au quotidien.',
                'DescriptionsAR' => 'تمارين مصممة لتحسين القوة والحركة المفيدة في الحياة اليومية.',
                'rows' => [
                    [
                        'ID_Type_Photo' => 2,
                        'Text' => 'Amélioration de la posture et de la coordination.',
                        'TextAR' => 'تحسين الوضعية والتنسيق.',
                        'Classement' => 1
                    ],
                    [
                        'ID_Type_Photo' => 1,
                        'Text' => 'Renforcement musculaire spécifique aux gestes quotidiens.',
                        'TextAR' => 'تقوية العضلات الخاصة بالأنشطة اليومية.',
                        'Classement' => 2
                    ]
                ]
            ],
            [
                'Nom' => 'Massage thérapeutique',
                'NomAR' => 'التدليك العلاجي',
                'Descriptions' => 'Massage ciblé pour soulager les tensions musculaires et favoriser la récupération.',
                'DescriptionsAR' => 'تدليك مستهدف لتخفيف التوتر العضلي وتعزيز التعافي.',
                'rows' => [
                    [
                        'ID_Type_Photo' => 1,
                        'Text' => 'Réduction du stress et des douleurs chroniques.',
                        'TextAR' => 'تقليل التوتر والآلام المزمنة.',
                        'Classement' => 1
                    ],
                    [
                        'ID_Type_Photo' => 2,
                        'Text' => 'Amélioration de la circulation et de la souplesse.',
                        'TextAR' => 'تحسين الدورة الدموية والمرونة.',
                        'Classement' => 2
                    ]
                ]
            ],
        ];

        foreach ($servicesData as $data) {
            $rows = $data['rows'];
            unset($data['rows']);
            
            $data['ID_Entreprise'] = 1;
            $data['Etat'] = true;
            $data['Photos'] = null;

            $service = Service::create($data);

            foreach ($rows as $row) {
                $row['ID_Service'] = $service->ID_Service;
                RowService::create($row);
            }
        }
    }
}
