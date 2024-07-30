<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPorteurProjet extends Model
{
    use HasFactory;
    
    protected $table = 'profil_porteur_projets';

    protected $primaryKey = 'type';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'montant'
    ];
}
