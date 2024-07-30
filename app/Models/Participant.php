<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'dateNais',
        'sexe',
        'ville',
        'numeroCNI',
        'porteurProjet',
        'presentationUn',
        'presentationDeux',
        'environnement',
        'impact',
        'financement',
        'telephone',
        'email',
        'places',
        'evenement',

    ];
}
