<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'Etudiant';
    protected $primaryKey = 'idEtudiant';
    public $timestamps = false; // Passez à true si vous avez ajouté created_at/updated_at

    protected $fillable = [
        'nomEtudiant',
        'villeEtudiant',
        'idUser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
}