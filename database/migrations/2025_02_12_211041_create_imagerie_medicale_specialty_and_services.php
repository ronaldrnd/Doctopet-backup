<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {


        // **🔹 Étape 2 : Récupérer l'ID de la nouvelle spécialité**
        $specialite_id = DB::table('specialites')->where('nom', 'Vétérinaires spécialisés en imagerie médicale')->value('id');


        if (!$specialite_id) {
            $specialite_id = DB::table('specialites')->insertGetId([
                'nom' => 'Vétérinaires spécialisés en imagerie médicale',
                'description' => 'Spécialistes de l’imagerie médicale pour le diagnostic et le suivi post-opératoire.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }


        // **🔹 Étape 3 : Création des services types**
        $services_types = [
            'Imagerie diagnostique' => 'Techniques avancées pour le diagnostic médical via imagerie.',
            'Suivi post-opératoire' => 'Contrôle médical et suivi des interventions chirurgicales par imagerie.',
        ];

        $services_types_ids = [];

        foreach ($services_types as $libelle => $description) {
            $id = DB::table('services_types')->insertGetId([
                'libelle' => $libelle,
                'color_tag' => '#ffffff', // Ajout de la couleur blanche par défaut
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $services_types_ids[$libelle] = $id;
        }

        // **🔹 Étape 4 : Lier la spécialité aux nouveaux services types**
        foreach ($services_types_ids as $id) {
            DB::table('specialite_services_types')->insert([
                'specialite_id' => $specialite_id,
                'services_types_id' => $id,
            ]);
        }

        // **🔹 Étape 5 : Récupérer les services templates existants et les assigner**
        $services_templates_mapping = [
            'Imagerie diagnostique' => [
                'Radiographie (articulations, thorax, abdomen)',
                'Échographie (gestation, organes internes)',
                'Scanner ou IRM pour diagnostics avancés',
            ],
            'Suivi post-opératoire' => [
                'Contrôle des implants ou des os fracturés',
            ],
        ];

        foreach ($services_templates_mapping as $service_type => $template_names) {
            $service_type_id = $services_types_ids[$service_type];

            foreach ($template_names as $name) {
                DB::table('service_templates')
                    ->where('name', $name)
                    ->update(['services_types_id' => $service_type_id]);
            }
        }
    }

    public function down()
    {
        // **🔹 Étape 1 : Supprimer les liaisons entre la spécialité et les services types**
        $specialite_id = DB::table('specialites')->where('nom', 'Vétérinaires spécialisés en imagerie médicale')->value('id');

        if ($specialite_id) {
            DB::table('specialite_services_types')->where('specialite_id', $specialite_id)->delete();
        }

        // **🔹 Étape 2 : Restaurer les services templates à NULL**
        $service_types_to_remove = ['Imagerie diagnostique', 'Suivi post-opératoire'];

        $services_types_ids = DB::table('services_types')
            ->whereIn('libelle', $service_types_to_remove)
            ->pluck('id', 'libelle');

        $service_templates_mapping = [
            'Radiographie (articulations, thorax, abdomen)',
            'Échographie (gestation, organes internes)',
            'Scanner ou IRM pour diagnostics avancés',
            'Contrôle des implants ou des os fracturés',
        ];

        DB::table('service_templates')
            ->whereIn('name', $service_templates_mapping)
            ->update(['services_types_id' => null]);

        // **🔹 Étape 3 : Supprimer les services types**
        DB::table('services_types')->whereIn('libelle', $service_types_to_remove)->delete();

        // **🔹 Étape 4 : Supprimer la spécialité**
        DB::table('specialites')->where('nom', 'Vétérinaires spécialisés en imagerie médicale')->delete();
    }
};
