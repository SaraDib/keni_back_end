<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            [
                'description_fr' => '<h2>Qui sommes-nous ?</h2><p>Global Healthy est un centre multidisciplinaire dédié au bien-être physique et mental. Notre mission est d\'offrir un accompagnement personnalisé à chaque patient pour une récupération optimale.</p>',
                'description_ar' => '<h2>من نحن؟</h2><p>جلوبال هيلثي هو مركز متعدد التخصصات مخصص للسلامة البدني والعقلي. مهمتنا هي تقديم دعم شخصي لكل مريض من أجل التعافي الأمثل.</p>',
                'active' => true,
            ],
            [
                'description_fr' => '<h2>Notre Vision</h2><p>Devenir la référence en matière de soins holistiques, en combinant technologie moderne et expertise humaine pour transformer la santé de nos patients.</p>',
                'description_ar' => '<h2>رؤيتنا</h2><p>أن نصبح المرجع في الرعاية الشمولية، من خلال الجمع بين التكنولوجيا الحديثة والخبرة البشرية لتحويل صحة مرضانا.</p>',
                'active' => true,
            ],
            [
                'description_fr' => '<h2>Pourquoi nous choisir ?</h2><p>Une équipe d\'experts certifiés, un plateau technique de pointe et une approche centrée sur l\'humain. Nous ne traitons pas seulement les symptômes, nous cherchons la source du problème.</p>',
                'description_ar' => '<h2>لماذا تختارنا؟</h2><p>فريق من الخبراء المعتمدين، ومنصة تقنية متطورة، ونهج يركز على الإنسان. نحن لا نعالج الأعراض فحسب، بل نبحث عن مصدر المشكلة.</p>',
                'active' => true,
            ],
            [
                'description_fr' => '<h2>Nos Valeurs</h2><p>Intégrité, professionnalisme et empathie sont au cœur de nos services. Chaque patient est unique et mérite une attention particulière.</p>',
                'description_ar' => '<h2>قيمنا</h2><p>النزاهة والمهنية والتعاطف هي جوهر خدماتنا. كل مريض فريد ويستحق اهتمامًا خاصًا.</p>',
                'active' => true,
            ],
        ];

        foreach ($contents as $content) {
            AboutUs::create($content);
        }
    }
}
