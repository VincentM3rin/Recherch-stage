<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $table = 'Entreprise';
    protected $primaryKey = 'idEntreprise';
    public $timestamps = false; // Passez à true si vous avez ajouté created_at/updated_at

    protected $fillable = [
        'nomEntreprise',
        'villeEntreprise',
        'photoEntreprise',
        'idType',
        'idUser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }

    public function type()
    {
        return $this->belongsTo(TypeEntreprise::class, 'idType', 'idType');
    }
    public function points()
    {
        return $this->hasMany(Point::class, 'idEntreprise', 'idEntreprise');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'idEntreprise', 'idEntreprise');
    }
}