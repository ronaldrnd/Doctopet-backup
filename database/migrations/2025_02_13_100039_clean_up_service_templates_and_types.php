<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CleanUpServiceTemplatesAndTypes extends Migration
{
    public function up()
    {
        DB::beginTransaction();

        try {
            // 🔹 Étape 1 : Supprimer les services_templates qui n'ont pas de services_types_id
            DB::table('service_templates')->whereNull('services_types_id')->delete();

            // 🔹 Étape 2 : Supprimer les services_types qui n'ont plus aucun service_template associé
            $unused_services_types = DB::table('services_types')
                ->leftJoin('service_templates', 'services_types.id', '=', 'service_templates.services_types_id')
                ->whereNull('service_templates.id')
                ->pluck('services_types.id');

            if ($unused_services_types->isNotEmpty()) {
                DB::table('services_types')->whereIn('id', $unused_services_types)->delete();
            }

            // 🔹 Étape 3 : Suppression des doublons dans `service_templates`
            $duplicates = DB::table('service_templates')
                ->select('name', DB::raw('COUNT(*) as count'))
                ->groupBy('name')
                ->having('count', '>', 1)
                ->get();

            foreach ($duplicates as $duplicate) {
                $ids = DB::table('service_templates')
                    ->where('name', $duplicate->name)
                    ->orderBy('id', 'asc')
                    ->pluck('id')
                    ->toArray();

                // Garder le premier et supprimer les autres doublons
                array_shift($ids);
                DB::table('service_templates')->whereIn('id', $ids)->delete();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Erreur dans la migration : " . $e->getMessage());
        }
    }

    public function down()
    {
        // Cette migration supprime définitivement des données, pas de restauration possible
    }
}
