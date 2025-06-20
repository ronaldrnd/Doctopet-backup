<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Récupération des IDs des services_types en fonction du libellé
        $servicesTypes = DB::table('services_types')->pluck('id', 'libelle');

        DB::table('service_templates')->insert([
            // CONSULTATIONS GÉNÉRALES
            ['name' => 'Consultation générale',
                'description' => 'Consultation vétérinaire pour évaluer l’état général de l’animal et conseiller sur sa santé.',
                'price' => 45.00,
                'duration' => 30,
                'gap_between_services' => 15,
                'services_types_id' => $servicesTypes['Consultation']],

            // CONSULTATIONS VACCINALES - CHAT
            ['name' => 'Consultation vaccinale chat - Valence rage',
                'description' => 'Vaccination contre la rage pour les chats, obligatoire pour voyager dans certains pays.',
                'price' => 50.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Consultation vaccinale chat - Valence FeLV',
                'description' => 'Vaccination contre la leucémie féline, recommandée pour les chats ayant accès à l’extérieur.',
                'price' => 55.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Consultation vaccinale chat - Valence HCPL',
                'description' => 'Vaccination contre Coryza et Typhus pour protéger votre chat contre les maladies virales.',
                'price' => 60.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            // CONSULTATIONS VACCINALES - CHIEN
            ['name' => 'Consultation vaccinale chien - Valence rage',
                'description' => 'Vaccination contre la rage pour les chiens, essentielle pour prévenir cette maladie mortelle.',
                'price' => 55.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Consultation vaccinale chien - Valence CHLRPPI',
                'description' => 'Vaccination contre plusieurs maladies graves du chien (Parvovirose, Hépatite, Leptospirose, etc.).',
                'price' => 60.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Consultation vaccinale chien - Valence LR',
                'description' => 'Vaccination combinée contre la Leptospirose et la Rage chez le chien.',
                'price' => 65.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Consultation vaccinale chien - Valence CHPPI',
                'description' => 'Vaccination combinée contre la Maladie de Carré, Hépatite contagieuse et Parvovirose.',
                'price' => 70.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            ['name' => 'Vaccination HCPL pour chat / CHRPPI/CHPPI pour chien',
                'description' => 'Vaccination combinée pour protéger efficacement chats et chiens contre plusieurs maladies virales.',
                'price' => 75.00,
                'duration' => 30,
                'gap_between_services' => 10,
                'services_types_id' => $servicesTypes['Vaccination']],

            // EUTHANASIE
            ['name' => 'Euthanasie chat',
                'description' => 'Euthanasie réalisée avec douceur et respect dans un cadre médicalisé.',
                'price' => 80.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Consultation']],

            ['name' => 'Euthanasie chien',
                'description' => 'Euthanasie pour chien, avec possibilité d’options de crémation.',
                'price' => 100.00,
                'duration' => 60,
                'gap_between_services' => 20,
                'services_types_id' => $servicesTypes['Consultation']],
        ]);
    }

    public function down(): void
    {
        DB::table('service_templates')->whereIn('name', [
            'Consultation générale',
            'Consultation vaccinale chat - Valence rage',
            'Consultation vaccinale chat - Valence FeLV',
            'Consultation vaccinale chat - Valence HCPL',
            'Consultation vaccinale chien - Valence rage',
            'Consultation vaccinale chien - Valence CHLRPPI',
            'Consultation vaccinale chien - Valence LR',
            'Consultation vaccinale chien - Valence CHPPI',
            'Vaccination HCPL pour chat / CHRPPI/CHPPI pour chien',
            'Euthanasie chat',
            'Euthanasie chien',
        ])->delete();
    }
};
