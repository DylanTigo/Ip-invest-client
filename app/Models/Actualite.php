<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    use HasFactory;

    protected $fillable = [
        'secteur',
        'projet',
        'libelle',
        'description',
        'image'
    ];



    public function secteur_data()
    {
        return $this->belongsTo(Secteur::class, 'secteur', 'id')->with('conseiller_data');
    }
    

    public function projet_invest()
    {
        return $this->belongsTo(Projet::class, 'projet', 'id')->with(['user_data', 'secteur_data']);
    }
}
