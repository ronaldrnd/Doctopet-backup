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
        $education = DB::table('services_types')->where('libelle', 'Éducation comportementale')->first();
        $osteopathie = DB::table('services_types')->where('libelle', 'Ostéopathie')->first();

        if ($education) {
            DB::table('service_templates')->insert([
                // 🎓 Éducation comportementale
                [
                    'name' => 'Rééducation comportementale',
                    'description' => 'Correction des comportements indésirables (agressivité, anxiété, phobies).',
                    'price' => 60.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Socialisation du chiot ou chien adulte',
                    'description' => 'Mise en contact avec d’autres chiens et humains pour un bon développement.',
                    'price' => 50.00,
                    'duration' => 45,
                    'gap_between_services' => 20,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Gestion des aboiements excessifs',
                    'description' => 'Enseignement des bonnes pratiques pour limiter les aboiements inappropriés.',
                    'price' => 55.00,
                    'duration' => 50,
                    'gap_between_services' => 20,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Apprentissage de la propreté',
                    'description' => 'Techniques et accompagnement pour aider les chiots et chiens adultes à être propres.',
                    'price' => 45.00,
                    'duration' => 40,
                    'gap_between_services' => 15,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Obéissance de base',
                    'description' => 'Cours d’obéissance de base : assis, couché, rappel, marche en laisse.',
                    'price' => 65.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Dressage avancé',
                    'description' => 'Enseignement des compétences avancées (sports canins, tricks, protection).',
                    'price' => 80.00,
                    'duration' => 90,
                    'gap_between_services' => 40,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Préparation aux activités canines',
                    'description' => 'Formation pour agility, pistage et autres disciplines sportives.',
                    'price' => 70.00,
                    'duration' => 75,
                    'gap_between_services' => 30,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Sessions collectives de socialisation',
                    'description' => 'Cours en groupe pour améliorer la sociabilité et les interactions.',
                    'price' => 40.00,
                    'duration' => 60,
                    'gap_between_services' => 20,
                    'services_types_id' => $education->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        if ($osteopathie) {
            DB::table('service_templates')->insert([
                // 🦴 Ostéopathie animale
                [
                    'name' => 'Gestion des douleurs musculo-squelettiques',
                    'description' => 'Techniques pour soulager douleurs musculaires et tensions articulaires.',
                    'price' => 70.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $osteopathie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Traitement des troubles articulaires',
                    'description' => 'Soins spécifiques pour arthrose, dysplasie et autres pathologies articulaires.',
                    'price' => 80.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $osteopathie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Soins post-traumatiques',
                    'description' => 'Rééducation après accident ou chirurgie pour restaurer la mobilité.',
                    'price' => 85.00,
                    'duration' => 75,
                    'gap_between_services' => 30,
                    'services_types_id' => $osteopathie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Suivi des animaux de sport',
                    'description' => 'Accompagnement des chiens et chevaux sportifs pour maintenir leur performance.',
                    'price' => 90.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $osteopathie->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Amélioration de la mobilité générale',
                    'description' => 'Techniques pour améliorer la flexibilité et la motricité des animaux vieillissants.',
                    'price' => 75.00,
                    'duration' => 60,
                    'gap_between_services' => 30,
                    'services_types_id' => $osteopathie->id,
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
            'Rééducation comportementale',
            'Socialisation du chiot ou chien adulte',
            'Gestion des aboiements excessifs',
            'Apprentissage de la propreté',
            'Obéissance de base',
            'Dressage avancé',
            'Préparation aux activités canines',
            'Sessions collectives de socialisation',
            'Gestion des douleurs musculo-squelettiques',
            'Traitement des troubles articulaires',
            'Soins post-traumatiques',
            'Suivi des animaux de sport',
            'Amélioration de la mobilité générale',
        ])->delete();
    }
};
