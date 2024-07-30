<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilInvestisseur extends Model
{
    use HasFactory;
    
    protected $table = 'profile_investisseurs';

    protected $fillable = [
        'type',
        'montant_min',
        'montant_max',
        'frais_abonnement'
    ];

    protected $appends =  [
        'max',
        'min',
        'frais'
    ];

    public function getMaxAttribute()
    {
        if (empty($this->montant_max)) {
            return 'Plus';
        }
        return $this->montant_max . ' XAF';
    }

    public function getMinAttribute()
    {
        return $this->montant_min . ' XAF';
    }

    public function getFraisAttribute()
    {
        return $this->frais_abonnement . ' XAF';
    }
}
