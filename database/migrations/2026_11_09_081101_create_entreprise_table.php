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
        Schema::create('Entreprise', function (Blueprint $table) {
            $table->id('idEntreprise');
            $table->text('nomEntreprise')->nullable();
            $table->text('villeEntreprise')->nullable();
            $table->text('photoEntreprise')->nullable();
        
            $table->unsignedBigInteger('idType');
            $table->unsignedBigInteger('idUser')->unique();

            $table->foreign('idType')->references('idType')->on('TypeEntreprise')->onDelete('cascade');
            $table->foreign('idUser')->references('idUser')->on('Utilisateurs')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprise');
    }
};
