<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projet;
use App\Models\Secteur;
use App\Models\Investissement;

class Dashboard extends Controller
{
    //

    public function countproject(){
        $users = User::where('role', 3)->with(['role_data'])->get();
        $invest = User::where('role', 4)->with(['role_data'])->get();
        $conseiller = User::where('role', 2)->with(['role_data'])->get();
        $projet = Projet::all();
        $secteur = Secteur::all();
        $investissement = Investissement::all()->sum('montant');
        $etat= Projet::select('etat', Projet::raw('COUNT(etat) as total_etat'))->groupBy('etat')->get();
        $pays= Projet::select( 'pays_activite', Projet::raw('COUNT(id) as total_projets'))->groupBy('pays_activite')->get();
        $secteurCouv= Projet::select( 'secteur')->groupBy('secteur')->get();
        $besoinFinancement= Projet::all()->sum('financement');


        return view('pages/dashboard.home' , [
            'porteurs'=> $users,
            'investisseurs'=> $invest,
            'conseiller'=> $conseiller,
            'nbProjets'=> $projet,
            'secteur'=> $secteur,
            'investissement'=> $investissement,
            'etat'=>$etat,
            'pays'=>$pays,
            'secteurCouv'=>$secteurCouv,
            'besoinFinancement'=>$besoinFinancement
        ]);
    }
    public function countprojectConseiller(){
        $invest = User::where('role', 4)->with(['role_data'])->get();
        $conseiller = User::where('role', 2)->with(['role_data'])->get();
        $projet = Projet::all();
        $secteur = Secteur::all();
        $investissement = Investissement::all()->sum('montant');
        $etat= Projet::select('etat', Projet::raw('COUNT(etat) as total_etat'))->groupBy('etat')->get();
        $pays= Projet::select( 'pays_activite', Projet::raw('COUNT(id) as total_projets'))->groupBy('pays_activite')->get();
        $secteurCouv= Projet::select( 'secteur')->groupBy('secteur')->get();
        $besoinFinancement= Projet::all()->sum('financement');


        return view('pages/dashboard.home' , [
            'porteurs'=> $users,
            'investisseurs'=> $invest,
            'conseiller'=> $conseiller,
            'nbProjets'=> $projet,
            'secteur'=> $secteur,
            'investissement'=> $investissement,
            'etat'=>$etat,
            'pays'=>$pays,
            'secteurCouv'=>$secteurCouv,
            'besoinFinancement'=>$besoinFinancement
        ]);
    }
}
