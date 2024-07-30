<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'projet_id',
        'event_id',
        'trans_id',
        'telephone',
        'methode',
        'montant',
        'valider',
        'type',
        'etat',
        'participant_id'
    ];

    protected $casts = [
        'valider' => 'boolean',
    ];

    protected $appends =  [
        'type_complet',
        'etat_complet',
        'methode_complet',
        'is_client',
        'color'
    ];

    public function getIsClientAttribute()
    {
        switch ($this->user_id) {
            case null:
                return false;
            default:
                return true;
        }
    }

    public function getTypeCompletAttribute()
    {
        switch ($this->type) {
            case 'INSCRIPTION':
                return 'Effectuer lors d\'une inscription';
            case 'PROFIL':
                return 'Effectuer lors de la mise à jour d\'une plage d\'investissement';
            case 'EVENT':
                return 'Effectuer lors de l\'enregistrement à un événement';
            default:
                return 'Effectuer lors de la validation d\'un projet';
        }
    }

    public function getEtatCompletAttribute()
    {
        switch ($this->etat) {
            case 'INITIE':
                return 'Initié';
            case 'REUSSI':
                return 'Réussi';
            default:
                return 'Échoué';
        }
    }

    public function getColorAttribute()
    {
        switch ($this->etat) {
            case 'INITIE':
                return 'bg-info';
            case 'REUSSI':
                return 'bg-success';
            default:
                return 'bg-danger';
        }
    }

    public function getMethodeCompletAttribute()
    {
        switch ($this->methode) {
            case 'OM':
                return 'Orange Money';
            case 'MOMO':
                return 'MTN Mobile Money';
            default:
                break;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id');
    }


    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Evenement::class, 'event_id', 'id');
    }
}
