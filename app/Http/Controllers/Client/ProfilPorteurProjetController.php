<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProfilPorteurProjet;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ProfilPorteurProjetController extends Controller
{
    public function index()
    {
        $profils = ProfilPorteurProjet::all();
        return view('pages.profil-porteur-projet.home')->with('profils', $profils);
    }

    public function add()
    {
        return view('pages.profil-porteur-projet.add');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'montant' => 'required|:profile_porteur_projets',
                'type' => 'required|:profile_porteur_projets',
            ],

            [
                'montant.required' => 'Champ obligatoire!',
                'type.required' => 'Champ obligatoire!',
            ]
        );

        $data = $request->input();

        ProfilPorteurProjet::create($data);

        Toastr::success('Profil ajouté avec succès!', 'Succès');

        return redirect()->intended(route('profil.porteur.home'));
    }

    public function edit($type)
    {
        $profil = ProfilPorteurProjet::find($type);
        return view('pages.profil-porteur-projet.edit')->with('profil', $profil);
    }

    public function update($type, Request $request)
    {

        $request->validate(
            [
                'montant' => 'required|:profile_porteur_projets',
                'type' => 'required|:profile_porteur_projets',
            ],

            [
                'montant.required' => 'Champ obligatoire!',
                'type.required' => 'Champ obligatoire!',
            ]
        );
        
        $data = $request->except(['_token']);

        ProfilPorteurProjet::where('type', $type)->update($data);

        Toastr::success('Profil mis à jour avec succès!)', 'Success');

        return redirect()->intended(route('profil.porteur.home'));
    }

    public function delete($type){

        ProfilPorteurProjet::find($type)->delete();
        Toastr::success('Profil supprimé avec succès!', 'Success');

        return back();
        
    }
}
