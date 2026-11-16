<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    protected $table = 'Candidature';
    protected $primaryKey = 'idCandidature';
    public $timestamps = false;

    protected $fillable = [
        'cvEtudiant',
        'demandeStage',
        'dateDebutStage',
        'dateFinStage',
        'dateEnvoi',
        'statut',
        'idEntreprise',
        'idEtudiant',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'idEntreprise', 'idEntreprise');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'idEtudiant', 'idEtudiant');
    }
}