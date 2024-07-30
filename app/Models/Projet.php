<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitule',
        'folder',
        'pays_activite',
        'ville_activite',
        'site',
        'description',
        'taux_rentabilite',
        'duree',
        'rsi',
        'ca_previsionnel',
        'financement',
        'doc_presentation',
        'logo',
        'secteur',
        'user',
        'etat',
        'type',
        'avancement',
        'complet',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
    ];


    protected $appends =  [
        'etat_complet',
        'avancement_complet',
        'iv_total',
        'iv_count',
        'iv_pourcent'
    ];

    public function getEtatCompletAttribute()
    {
        switch ($this->etat) {
            case 'ATTENTE':
                return 'En attente d\'approbation';
                break;
            case 'VALIDE':
                return 'Validé';
                break;
            case 'COMPLET':
                return 'Étude terminée';
                break;
            case 'ATTENTE_VALIDATION_ADMIN':
                return 'En attente de validation administrative';
                break;
            case 'ATTENTE_INFO_SUPPL':
                return 'Besoin d\'informations supplementaire';
                break;
            case 'ATTENTE_PAIEMENT':
                return 'En attente de paiement';
                break;
            case 'REJETE':
                return 'Rejeté';
                break;
            case 'CLOTURE':
                return 'Financement collecté';
                break;
            default:
                return 'Publié';
                break;
        }
    }

    public function getAvancementCompletAttribute()
    {
        switch ($this->avancement) {
            case 'IDEE':
                return 'Juste l\'idée';
                break;
            case 'PROTOTYPE':
                return 'Un prototype';
                break;
            default:
                return 'Projet sur le marché';
                break;
        }
    }

    public function membres()
    {
        return $this->belongsToMany(Membre::class, 'equipes', 'projet', 'membre')->withPivot('statut');
    }

    public function secteur_data()
    {
        return $this->belongsTo(Secteur::class, 'secteur', 'id')->with(['conseiller_data']);
    }

    public function medias()
    {
        return $this->hasMany(Archive::class, 'projet', 'id');
    }

    public function investissements()
    {
        return $this->hasMany(Investissement::class, 'projet', 'id')->with(['user_data']);
    }

    public function likes()
    {
        return $this->hasMany(ProjectLike::class, 'projet', 'id');
    }

    public function user_data()
    {
        return $this->belongsTo(User::class, 'user', 'id')->with(['profil_porteur']);
    }

    public function actualites()
    {
        return $this->hasMany(Actualite::class, 'projet', 'id');
    }

    public function getIvTotalAttribute()
    {
        $total = Investissement::select(DB::raw('sum(montant) as total_investi'))->where('projet', $this->id)->first();

        if (empty($total->total_investi)) {
            return 0;
        }
        return (int) $total->total_investi;
    }

    public function getIvPourcentAttribute()
    {
        if ($this->iv_total == 0) {
            return 0;
        }
        return ((int) $this->iv_total / (int) $this->financement) * 100;
    }

    public function getIvCountAttribute()
    {
        $total = Investissement::select('user')
            ->where('projet', $this->id)
            ->groupBy('user')
            ->get();

        return count($total);
    }
}
