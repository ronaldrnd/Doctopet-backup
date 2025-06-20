<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Récupération des IDs des services_types en fonction du libellé
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        DB::table('service_templates')->insert([
            // **CHIRURGIE - CASTRATION**
            ['name' => 'Castration chat',
                'description' => 'Intervention chirurgicale de stérilisation pour chat mâle.',
                'price' => 70.00,
                'duration' => 45,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Castration chien',
                'description' => 'Castration pour chien mâle afin de limiter les comportements liés aux hormones.',
                'price' => 100.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Castration NAC',
                'description' => 'Castration pour Nouveaux Animaux de Compagnie (lapins, furets, rongeurs).',
                'price' => 80.00,
                'duration' => 45,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Chirurgie']],

            // **CHIRURGIE - OVARIECTOMIE & OVARIOHYSTÉRECTOMIE**
            ['name' => 'Ovariectomie chienne',
                'description' => 'Intervention chirurgicale pour stérilisation des chiennes.',
                'price' => 150.00,
                'duration' => 90,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Ovariectomie chatte',
                'description' => 'Stérilisation des chattes pour éviter les gestations et chaleurs.',
                'price' => 90.00,
                'duration' => 60,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Ovariohystérectomie chienne',
                'description' => 'Stérilisation complète de la chienne, incluant l’ablation de l’utérus.',
                'price' => 170.00,
                'duration' => 90,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Ovariohystérectomie chatte',
                'description' => 'Stérilisation complète de la chatte, incluant l’ablation de l’utérus.',
                'price' => 110.00,
                'duration' => 60,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']],

            // **AUTRES CHIRURGIES**
            ['name' => 'Césarienne chienne',
                'description' => 'Intervention d’urgence ou programmée pour l’accouchement des chiennes.',
                'price' => 200.00,
                'duration' => 120,
                'gap_between_services' => 45,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Césarienne chatte',
                'description' => 'Opération permettant d’aider une chatte en difficulté lors de la mise bas.',
                'price' => 180.00,
                'duration' => 90,
                'gap_between_services' => 45,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Détartrage chien',
                'description' => 'Détartrage et nettoyage complet des dents du chien sous anesthésie.',
                'price' => 90.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Dentisterie']],

            ['name' => 'Détartrage chat',
                'description' => 'Détartrage et nettoyage complet des dents du chat sous anesthésie.',
                'price' => 80.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Dentisterie']],

            ['name' => 'Avortement chienne (2 injections)',
                'description' => 'Interruption de gestation par injections adaptées pour la chienne.',
                'price' => 120.00,
                'duration' => 60,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Chirurgie']],

            ['name' => 'Identification électronique (puce)',
                'description' => 'Implantation d’une puce électronique pour identifier votre animal.',
                'price' => 70.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Consultation']],

            // **IMAGERIE ET SOINS COMPLÉMENTAIRES**
            ['name' => 'Radiographie (par cliché)',
                'description' => 'Radiographie permettant d’examiner les os et certains organes internes.',
                'price' => 60.00,
                'duration' => 30,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Imagerie']],

            ['name' => 'Journée d’hospitalisation',
                'description' => 'Surveillance et soins en clinique vétérinaire pour animaux nécessitant un suivi médical.',
                'price' => 120.00,
                'duration' => 480,
                'gap_between_services' => 60,
                'services_types_id' => $servicesTypes['Soins']],
        ]);
    }

    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Castration chat',
            'Castration chien',
            'Castration NAC',
            'Ovariectomie chienne',
            'Ovariectomie chatte',
            'Ovariohystérectomie chienne',
            'Ovariohystérectomie chatte',
            'Césarienne chienne',
            'Césarienne chatte',
            'Détartrage chien',
            'Détartrage chat',
            'Avortement chienne (2 injections)',
            'Identification électronique (puce)',
            'Radiographie (par cliché)',
            'Journée d’hospitalisation',
        ])->delete();
    }
};
