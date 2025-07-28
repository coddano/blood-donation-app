<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Supprimer l'ancienne contrainte de clé étrangère
            $table->dropForeign(['villes_id']);
            // Renommer la colonne
            $table->renameColumn('villes_id', 'ville_id');
            // Ajouter la nouvelle contrainte de clé étrangère
            $table->foreign('ville_id')->references('id')->on('villes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demandes', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['ville_id']);
            // Renommer la colonne en arrière
            $table->renameColumn('ville_id', 'villes_id');
            // Ajouter l'ancienne contrainte de clé étrangère
            $table->foreign('villes_id')->references('id')->on('villes');
        });
    }
};
