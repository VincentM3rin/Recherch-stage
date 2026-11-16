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
        Schema::create('Etudiant', function (Blueprint $table) {
            $table->id('idEtudiant');
            $table->text('nomEtudiant')->nullable();
            $table->text('villeEtudiant')->nullable();
        
            $table->unsignedBigInteger('idUser')->unique();
            $table->foreign('idUser')->references('idUser')->on('Utilisateurs')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiant');
    }
};
