<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investissement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'projet',
        'date_versement',
        'facture_versement',
        'montant',
        'folder',
        'facture_file'
    ];


    public function projet_data()
    {
        return $this->belongsTo(Projet::class, 'projet', 'id')->with(['secteur_data']);
    }


    public function user_data()
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
