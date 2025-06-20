<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Exécute la migration.
     */
    public function up(): void
    {
        // Supprimer les enregistrements de service_templates sans relation valide dans services_types
        DB::table('service_templates')
            ->whereNotIn('services_types_id', function ($query) {
                $query->select('id')
                    ->from('services_types');
            })
            ->delete();
    }

    /**
     * Annule la migration.
     */
    public function down(): void
    {
        // Pas de retour en arrière possible car les enregistrements supprimés ne peuvent pas être restaurés
    }
};
