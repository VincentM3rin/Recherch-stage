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
        Schema::create('Commentaire', function (Blueprint $table) {
            $table->id('idCommentaire');
            $table->text('titreCommentaire')->nullable();
            $table->text('contenu')->nullable();
        
            $table->unsignedBigInteger('idEtudiant');
            $table->foreign('idEtudiant')->references('idEtudiant')->on('Etudiant')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaire');
    }
};
