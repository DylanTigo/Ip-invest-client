<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use Illuminate\Support\Facades\DB;


class ActualiteController extends Controller
{
    public function index()
    {
        // $actualites = Actualite::whereNotNull('secteur')->get();
        // return $this->sendResponse($actualites, 'Actualités récupérées avec succès.');
        $actualites = DB::table('actualites')
        ->join('secteurs', 'actualites.secteur', '=', 'secteurs.id')
        ->whereNotNull('actualites.secteur')
        ->select('actualites.*', 'secteurs.libelle as secteur_libelle')
        ->get();

    // Retourner les résultats avec un message de succès
    return $this->sendResponse($actualites, 'Actualités récupérées avec succès.');
    }
    

    public function show($id)
    {
        try {
            $actualite = DB::table('actualites')
                ->join('secteurs', 'actualites.secteur', '=', 'secteurs.id')
                ->where('actualites.id', $id)
                ->select('actualites.*', 'secteurs.libelle as secteur_libelle')
                ->first(); // Récupérer un seul enregistrement
    
            if (!$actualite) {
                return response()->json(['message' => 'Actualité non trouvée'], 404);
            }
    
            return $this->sendResponse($actualite, 'Actualité récupérée avec succès.');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de l\'actualité', 'error' => $e->getMessage()], 500);
        }
    }
    
}
