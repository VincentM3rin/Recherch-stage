<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Utilisateurs';
    protected $primaryKey = 'idUser';

    protected $fillable = [
        'nomUser',
        'mdpUser',
        'role',
    ];

    protected $hidden = [
        'mdpUser',
    ];

    public function getAuthPassword()
    {
        return $this->mdpUser;
    }

    public function entreprise()
    {
        return $this->hasOne(Entreprise::class, 'idUser', 'idUser');
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'idUser', 'idUser');
    }
}