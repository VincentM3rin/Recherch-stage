<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEntreprise extends Model
{
    // On indique à Laravel le nom exact de votre table
    protected $table = 'TypeEntreprise';

    // On précise que votre clé primaire n'est pas "id" mais "idType"
    protected $primaryKey = 'idType';

    // On autorise le remplissage de la colonne libelType
    protected $fillable = ['libelType'];
}