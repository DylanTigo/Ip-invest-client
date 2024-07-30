<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProfilInvestisseur;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ProfilInvestisseurController extends Controller
{
    public function index()
    {
        $profils = ProfilInvestisseur::all();
        return view('pages.profil-investisseur.home')->with('profils', $profils);
    }

    public function add()
    {
        return view('pages.profil-investisseur.add');
    }

    public function store(Request $request)
    {

        $validated = $request->validate(
            [
                'montant_min' => 'required|:profile_investisseurs',
                'frais_abonnement' => 'required|:profile_investisseurs',
                'type' => 'required|unique:profile_investisseurs',
            ],

            [
                'montant_min.required' => 'Champ obligatoire!',
                'frais_abonnement.required' => 'Champ obligatoire!',
                'type.required' => 'Champ obligatoire!',
                'type.unique' => 'Ce champ a déja été ajouté!',
            ]
        );

        $data = $request->input();

        ProfilInvestisseur::create($data);

        Toastr::success('Profil ajouté avec succès!', 'Succès');

        return redirect()->intended(route('profil.investisseur.home'));
    }

    public function edit($id)
    {
        $profil = ProfilInvestisseur::find($id);
        return view('pages.profil-investisseur.edit')->with('profil', $profil);
    }

    public function update($id, Request $request)
    {

        $validated = $request->validate(
            [
                'montant_min' => 'required|:profile_investisseurs',
                'frais_abonnement' => 'required|:profile_investisseurs',
                'type' => 'required|:profile_investisseurs',
            ],

            [
                'montant_min.required' => 'Champ obligatoire!',
                'frais_abonnement.required' => 'Champ obligatoire!',
                'type.required' => 'Champ obligatoire!',
            ]
        );
        
        $data = $request->except(['_token']);

        ProfilInvestisseur::where('id', $id)->update($data);

        Toastr::success('Profil mis à jour avec succès!)', 'Success');

        $profils = ProfilInvestisseur::all();
        return view('pages.profil-investisseur.home')->with('profils', $profils);
    }

    public function delete($id){

        ProfilInvestisseur::find($id)->delete();
        Toastr::success('Profil supprimé avec succès!', 'Success');

        return redirect()->intended(route('profil.investisseur.home'));
        
    }
}
