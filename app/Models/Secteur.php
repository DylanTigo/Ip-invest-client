<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'libelle',
        'slug',
        'user',
        'photo',
    ];

    public function conseiller_data()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'secteur', 'id');
    }

    public function actualites()
    {
        return $this->hasMany(Actualite::class, 'secteur', 'id');
    }
}
