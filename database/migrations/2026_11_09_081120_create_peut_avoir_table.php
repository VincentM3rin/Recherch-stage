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
        Schema::create('Peut_avoir', function (Blueprint $table) {
            $table->unsignedBigInteger('idEntreprise');
            $table->unsignedBigInteger('idCommentaire');

            $table->primary(['idEntreprise', 'idCommentaire']); // Clé primaire composite
        
            $table->foreign('idEntreprise')->references('idEntreprise')->on('Entreprise')->onDelete('cascade');
            $table->foreign('idCommentaire')->references('idCommentaire')->on('Commentaire')->onDelete('cascade');
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peut_avoir');
    }
};
