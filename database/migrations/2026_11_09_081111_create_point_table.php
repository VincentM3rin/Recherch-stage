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
        Schema::create('Point', function (Blueprint $table) {
            $table->id('idPoint');
            $table->decimal('longEntreprise', 10, 7)->nullable();
            $table->decimal('latEntreprise', 10, 7)->nullable();
        
            $table->unsignedBigInteger('idEntreprise');
            $table->foreign('idEntreprise')->references('idEntreprise')->on('Entreprise')->onDelete('cascade');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point');
    }
};
