<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\User;
use App\Models\Secteur;
use App\Models\Investissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function countproject()
    {
        $users = User::where('role', 3)->with(['role_data'])->get();
        $invest = User::where('role', 4)->with(['role_data'])->get();
        $conseiller = User::where('role', 2)->with(['role_data'])->get();
        $privileges = DB::table('privileges')
            ->where('user', auth()->user()->id)
            ->get();

        if (auth()->user()->role == 1 || auth()->user()->role == 5) {
            $projet = Projet::all();
            $secteur = Secteur::with(['projets'])->get();
            $investissement = Investissement::all()->sum('montant');
            $etat = Projet::select('etat', Projet::raw('COUNT(etat) as total_etat'))->groupBy('etat')->get();
            $pays = Projet::select('pays_activite', Projet::raw('COUNT(id) as total_projets'))->groupBy('pays_activite')->get();
            $secteurCouv = Projet::select('secteur')->groupBy('secteur')->get();
            $besoinFinancement = $projet->sum('financement');
            $ip = DB::table('projets')
                ->where('type', 'IP')
                ->count();
            $autres = DB::table('projets')
                ->where('type', 'AUTRE')
                ->count();
                

            foreach ($pays as $key => $pay) {
                $pays[$key]->villes = DB::table('projets')->select('ville_activite', DB::raw('COUNT(id) as total_ville_projet'))
                    ->where('pays_activite', $pay->pays_activite)
                    ->groupBy('ville_activite')
                    ->get();
            }
        } else {
            $projet = Projet::whereIn('secteur', function ($query) {
                $query->select('id')
                    ->from(with(new Secteur())->getTable())
                    ->where('user', auth()->user()->id);
            })->get();

            $secteur = Secteur::where('user', auth()->user()->id)->with(['projets'])->get();

            $investissement = Investissement::whereIn('projet', function ($query) {
                $query->select('id')
                    ->from(with(new Projet())->getTable())
                    ->whereIn('secteur', function ($query) {
                        $query->select('id')
                            ->from(with(new Secteur())->getTable())
                            ->where('user', auth()->user()->id);
                    });
            })->get()->sum('montant');

            $etat = Projet::select('etat', Projet::raw('COUNT(etat) as total_etat'))
                ->whereIn('secteur', function ($query) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', auth()->user()->id);
                })
                ->groupBy('etat')->get();

            $pays = Projet::select('pays_activite', Projet::raw('COUNT(id) as total_projets'))
                ->whereIn('secteur', function ($query) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', auth()->user()->id);
                })
                ->groupBy('pays_activite')->get();

            $secteurCouv = Projet::select('secteur')
                ->whereIn('secteur', function ($query) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', auth()->user()->id);
                })
                ->groupBy('secteur')->get();

            $besoinFinancement = $projet->sum('financement');

            foreach ($pays as $key => $pay) {
                $pays[$key]->villes = DB::table('projets')->select('ville_activite', DB::raw('COUNT(id) as total_ville_projet'))
                    ->whereIn('secteur', function ($query) {
                        $query->select('id')
                            ->from(with(new Secteur())->getTable())
                            ->where('user', auth()->user()->id);
                    })
                    ->where('pays_activite', $pay->pays_activite)
                    ->groupBy('ville_activite')
                    ->get();
            }

            $ip = DB::table('projets')
                ->whereIn('secteur', function ($query) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', auth()->user()->id);
                })
                ->where('type', 'IP')
                ->count();
            $autres = DB::table('projets')
                ->whereIn('secteur', function ($query) {
                    $query->select('id')
                        ->from(with(new Secteur())->getTable())
                        ->where('user', auth()->user()->id);
                })
                ->where('type', 'AUTRE')
                ->count();
        }

        return view('pages/dashboard.home', [
            'porteurs' => $users,
            'investisseurs' => $invest,
            'conseiller' => $conseiller,
            'nbProjets' => $projet,
            'secteur' => $secteur,
            'investissement' => $investissement,
            'etat' => $etat,
            'pays' => $pays,
            'secteurCouv' => $secteurCouv,
            'besoinFinancement' => $besoinFinancement,
            'ip' => $ip,
            'autres' => $autres,
            'privileges' => $privileges
        ]);
    }
}
