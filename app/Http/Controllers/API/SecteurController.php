<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Secteur;
use Illuminate\Support\Facades\DB;

class SecteurController extends Controller
{
    public function index()
    {
        $secteurs = Secteur::all();
        return $this->sendResponse($secteurs, 'All domaines');
    }

    public function show($id)
    {
        $secteur = Secteur::find($id);
        $pays = Projet::select('pays_activite')
        ->distinct()
        ->where('secteur', $id)
        ->where('etat', 'PUBLIE')
        ->get();
        foreach ($pays as $key => $value) {
            $data = [
                'libelle' => $value->pays_activite,
                'viles' => Projet::select(DB::raw('ville_activite as libelle'))
                    ->distinct()
                    ->where('secteur', $id)
                    ->where('etat', 'PUBLIE')
                    ->where('pays_activite', $value->pays_activite)
                    ->get()
            ];

            $pays[$key] = $data;
        }
        $secteur->pays = $pays;
        return $this->sendResponse($secteur, 'Get one secteur countries');
    }
}
