<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Récupération des IDs des services_types en fonction du libellé
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        DB::table('service_templates')->insert([
            // **IMAGERIE DIAGNOSTIQUE**
            [
                'name' => 'Radiographie (articulations, thorax, abdomen)',
                'description' => 'Examen radiographique permettant d\'analyser l\'état des articulations, du thorax et de l\'abdomen.',
                'price' => 75.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Imagerie']
            ],
            [
                'name' => 'Échographie (gestation, organes internes)',
                'description' => 'Examen échographique permettant de visualiser les organes internes et de surveiller la gestation.',
                'price' => 90.00,
                'duration' => 45,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Imagerie']
            ],
            [
                'name' => 'Scanner ou IRM pour diagnostics avancés',
                'description' => 'Imagerie avancée permettant de détecter des anomalies internes et de préciser un diagnostic médical.',
                'price' => 350.00,
                'duration' => 120,
                'gap_between_services' => 30,
                'services_types_id' => $servicesTypes['Imagerie']
            ],

            // **SUIVI POST-OPÉRATOIRE**
            [
                'name' => 'Contrôle des implants ou des os fracturés',
                'description' => 'Évaluation post-opératoire pour vérifier l’état des implants et la consolidation des fractures.',
                'price' => 80.00,
                'duration' => 40,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Orthopédie']
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Radiographie (articulations, thorax, abdomen)',
            'Échographie (gestation, organes internes)',
            'Scanner ou IRM pour diagnostics avancés',
            'Contrôle des implants ou des os fracturés'
        ])->delete();
    }
};
