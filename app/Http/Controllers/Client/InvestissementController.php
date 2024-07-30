<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\AddInvestissement;
use App\Mail\AddInvestissementP;
use App\Models\Investissement;
use App\Models\Projet;
use App\Models\User;
use App\Utils\Helpers;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class InvestissementController extends Controller
{
    public function index()
    {
        $investissements = Investissement::with(['projet_data', 'user_data'])->get();
        return view('pages.investissement.home', compact('investissements'));
    }

    public function add()
    {
        $investisseurs = User::where('role', 4)->get();
        $projets = Projet::where('etat', 'PUBLIE')->get();
        return view('pages.investissement.add', compact('investisseurs', 'projets'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'date_versement' => 'required',
                'investisseur' => 'required',
                'projet' => 'required',
                'montant_investi' => 'required',
                'facture_versement' => 'required',
            ],
            [
                'date_versement.required' => 'Champ obligatoire!',
                'investisseur.required' => 'Champ obligatoire!',
                'projet.required' => 'Champ obligatoire!',
                'montant_investi.required' => 'Champ obligatoire!',
                'facture_versement.required' => 'Champ obligatoire!',
            ]
        );


        // try {
            DB::beginTransaction();

            $projet = Projet::with(['user_data'])
                ->where('id', $request->projet)
                ->first();

            $montantInvesti = Investissement::where('projet', $request->projet)
                ->sum('montant');

            if ((int) $projet->financement < ((int) $montantInvesti + (int) $request->montant_investi)) {
                $reste = (int) $projet->financement - (int) $montantInvesti;
                $reste = Helpers::numberFormat($reste);
                return back()->withErrors([
                    'invest' => "Le projet \"$projet->intitule\" ne nécessite qu'un investissement de $reste FCFA.",
                ])->withInput();
            } else if ((int) $projet->financement == ((int) $montantInvesti + (int) $request->montant_investi)) {
                $projet->etat = 'CLOTURE';
            }

            $data = array();
            $data['user'] = $request->investisseur;
            $data['projet'] = $request->projet;
            $data['date_versement'] = Carbon::createFromFormat('d/m/Y', $request->date_versement)->toDateTimeString();
            $data['montant'] = $request->montant_investi;
            $data['folder'] = hexdec(uniqid());

            if ($request->has('facture_versement')) {
                $facture = $request->file('facture_versement');
                $fileExt = strtolower($facture->getClientOriginalExtension());
                $data['facture_file'] = 'facture.' . $fileExt;
                $data['facture_versement'] = url('storage/uploads/investments/' . $data['folder']) . '/' . $data['facture_file'];
                $facture->storeAs('uploads/investments/' . $data['folder'] . '/', $data['facture_file'], ['disk' => 'public']);
            }

            Investissement::create($data);

            $projet->save();

            $investissement = Investissement::with(['projet_data', 'user_data'])
                ->where('user', $data['user'])
                ->where('montant', $data['montant'])
                ->first();

            $admin = User::where('role', 1)->first();

            Mail::to($investissement->user_data->email)
                ->queue(new AddInvestissement($investissement->toArray(), $admin->toArray(), $projet->toArray()));

            Mail::to($projet->user_data->email)
                ->queue(new AddInvestissementP($investissement->toArray(), $admin->toArray(), $projet->toArray()));

            $user = User::find($projet->user_data->id);

            if (!empty($user->device_token)) {
                $user->sendFcmNotification("Nous avons le plaisir de vous annoncer que vous avez recu un
                investissement de $investissement->montant XAF pour votre projet '$projet->intitule'.", "Nouvelle investissement sur votre projet");
            }

            Mail::to('info@invest--partners.com')
                ->queue(new AddInvestissement($investissement->toArray(), $admin->toArray(), $projet->toArray()));

            Toastr::success('Investissement ajouté avec succès!', 'Succès');

            DB::commit();
            return redirect()->intended(route('investissement.home'));

        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     throw $th;
        //     return back()->with('error', "Impossible de publier l'investissement !");
        // }
    }

    public function edit($id)
    {
        $investissement = Investissement::with(['projet_data', 'user_data'])->find($id);
        $investisseurs = User::where('role', 4)->get();
        $projets = Projet::where('etat', 'PUBLIE')->get();
        return view('pages.investissement.edit', compact('investissement', 'investisseurs', 'projets'));
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'date_versement' => 'required|:investissements',
                'investisseur' => 'required|:investissements',
                'projet' => 'required|:investissements',
                'montant_investi' => 'required|:investissements',
            ],

            [
                'date_versement.required' => 'Champ obligatoire!',
                'investisseur.required' => 'Champ obligatoire!',
                'projet.required' => 'Champ obligatoire!',
                'montant_investi.required' => 'Champ obligatoire!',
            ]
        );

        $data = Investissement::find($id);

        $form = [
            'user' => $request->investisseur,
            'projet' => $request->projet,
            'date_versement' => Carbon::createFromFormat('d/m/Y', $request->date_versement)->toDateTimeString(),
            'montant' => $request->montant_investi
        ];

        if ($request->has('facture_versement')) {
            File::delete(storage_path('app/public/uploads/investments/' . $data->folder . '/' . $data->facture_file));
            $facture = $request->file('facture_versement');
            $fileExt = strtolower($facture->getClientOriginalExtension());
            $form['facture_file'] = 'facture.' . $fileExt;
            $form['facture_versement'] = url('storage/uploads/investments/' . $data->folder) . '/' . $form['facture_file'];
            $facture->storeAs('uploads/investments/' . $data->folder . '/', $form['facture_file'], ['disk' => 'public']);
        }

        // dd($form);

        $data->update($form);

        Toastr::success('Investissement modifié avec succès!', 'Succès');

        return redirect()->intended(route('investissement.home'));
    }

    public function delete($id)
    {
        $invest = Investissement::find($id);
        if ($invest->folder != null) {
            File::deleteDirectory(storage_path('app/public/uploads/investments') . $invest->folder);
        }
        Investissement::find($id)->delete();
        Toastr::success('Investissement supprimé avec succès!', 'Success');
        return redirect()->intended(route('investissement.home'));
    }
}
