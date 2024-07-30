<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_complet',
        'telephone',
        'email',
        'photo',
        'cni',
        'pays',
        'ville',
        'profession',
        'date_naissance',
        'parcours',
        'user',
    ];

    public function projet(){
        return $this->hasMany(Projet::class, 'projet', 'id');
    }
}


