<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Récupérer les ID des services types correspondants
        $chenils = DB::table('services_types')->where('libelle', 'Chenils')->first();
        $physiotherapie = DB::table('services_types')->where('libelle', 'Physiothérapie')->first();
        $kinesiologie = DB::table('services_types')->where('libelle', 'Kinésiologie')->first();

        if ($chenils) {
            DB::table('service_templates')->insert([
                // 🏡 Chenils
                [
                    'name' => 'Réservation pour hébergement court ou long terme',
                    'description' => 'Réservez un hébergement pour votre animal, en court ou long séjour.',
                    'price' => 30.00,
                    'duration' => 1440, // 24h
                    'gap_between_services' => 0,
                    'services_types_id' => $chenils->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Visite des installations avant une garde prolongée',
                    'description' => 'Planifiez une visite des installations avant une garde de longue durée pour votre animal.',
                    'price' => 10.00,
                    'duration' => 30,
                    'gap_between_services' => 15,
                    'services_types_id' => $chenils->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($physiotherapie) {
            DB::table('service_templates')->insert([
                // 🩺 Physiothérapie animale
                [
                    'name' => 'Rééducation post-chirurgicale',
                    'description' => 'Séances de rééducation pour aider votre animal à récupérer après une chirurgie.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $physiotherapie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Réhabilitation après traumatisme ou blessure',
                    'description' => 'Programme personnalisé pour restaurer la mobilité après un accident ou une blessure.',
                    'price' => 60.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $physiotherapie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Hydrothérapie',
                    'description' => 'Utilisation de l’eau pour améliorer la rééducation et la mobilité.',
                    'price' => 70.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $physiotherapie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Massages thérapeutiques pour douleurs chroniques',
                    'description' => 'Massages vétérinaires spécialisés pour soulager les douleurs chroniques.',
                    'price' => 40.00,
                    'duration' => 45,
                    'gap_between_services' => 30,
                    'services_types_id' => $physiotherapie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($kinesiologie) {
            DB::table('service_templates')->insert([
                // 💆 Kinésiologie animale
                [
                    'name' => 'Gestion du stress et des émotions',
                    'description' => 'Séances de kinésiologie pour réduire le stress et améliorer le bien-être général.',
                    'price' => 50.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $kinesiologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Amélioration de la vitalité générale',
                    'description' => 'Approche holistique pour restaurer l’énergie et la vitalité des animaux.',
                    'price' => 55.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $kinesiologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Aide pour troubles du comportement',
                    'description' => 'Séances personnalisées pour aider les animaux avec des troubles émotionnels ou comportementaux.',
                    'price' => 60.00,
                    'duration' => 75,
                    'gap_between_services' => 30,
                    'services_types_id' => $kinesiologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Accompagnement post-traumatique',
                    'description' => 'Programme de kinésiologie pour soutenir les animaux après un traumatisme.',
                    'price' => 65.00,
                    'duration' => 75,
                    'gap_between_services' => 30,
                    'services_types_id' => $kinesiologie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Réservation pour hébergement court ou long terme',
            'Visite des installations avant une garde prolongée',
            'Rééducation post-chirurgicale',
            'Réhabilitation après traumatisme ou blessure',
            'Hydrothérapie',
            'Massages thérapeutiques pour douleurs chroniques',
            'Gestion du stress et des émotions',
            'Amélioration de la vitalité générale',
            'Aide pour troubles du comportement',
            'Accompagnement post-traumatique',
        ])->delete();
    }
};
