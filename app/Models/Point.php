<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'Point';
    protected $primaryKey = 'idPoint';
    public $timestamps = false;

    protected $fillable = [
        'longEntreprise',
        'latEntreprise',
        'idEntreprise',
    ];

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'idEntreprise', 'idEntreprise');
    }
}