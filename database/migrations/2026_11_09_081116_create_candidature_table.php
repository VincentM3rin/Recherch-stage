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
        Schema::create('Candidature', function (Blueprint $table) {
            $table->id('idCandidature');
            $table->text('cvEtudiant')->nullable();
            $table->text('demandeStage')->nullable();
            $table->dateTime('dateDebutStage')->nullable();
            $table->dateTime('dateFinStage')->nullable();
            $table->dateTime('dateEnvoi')->nullable();
            $table->text('statut')->nullable();
        
            $table->unsignedBigInteger('idEntreprise');
            $table->unsignedBigInteger('idEtudiant');

            $table->foreign('idEntreprise')->references('idEntreprise')->on('Entreprise')->onDelete('cascade');
            $table->foreign('idEtudiant')->references('idEtudiant')->on('Etudiant')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidature');
    }
};
