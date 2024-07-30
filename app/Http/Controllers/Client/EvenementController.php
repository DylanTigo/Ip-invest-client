<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use App\Models\Participant;
use App\Models\Partenaire;
use App\Models\EvenementPartenaire;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class EvenementController extends Controller
{
    public function index()
    {
        $events = Evenement::with(['participants', 'partenaires'])->get();
        return view('pages.events.home', compact('events'));
    }

    public function add()
    {
        $partenaires = Partenaire::all(); 
        return view('pages.events.add', compact('partenaires'));
    }

    public function store(Request $request)
{
    
    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'fichier' => 'nullable|mimes:pdf|max:5120',
        'partenaires.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'date_debut' => 'nullable|date',
        'date_fin' => 'nullable|date',
        'heure_debut' => 'nullable|date_format:g:i A',
        'heure_fin' => 'nullable|date_format:g:i A',
        'prix' => 'nullable|numeric',
    ],
    [
        'libelle.required' => 'Champ obligatoire!',
        'image.required' => 'Champ obligatoire!',
        'fichier.required' => 'Champ obligatoire!',
        'partenaires.required' => 'Champ obligatoire!',
        'date_debut.required' => 'Champ obligatoire!',
        'heure_debut.required' => 'Champ obligatoire!',
        'prix.required' => 'Champ obligatoire!',
    ]
);

    $data = $request->except(['pay', 'partenaires']);
    $image = $request->file('image');
    $fichier = $request->file('fichier');
    $partenaireImages = $request->file('partenaires');
    $date_debut = $request->input('date_debut');
    $date_fin = $request->input('date_fin');
    $heure_debut = $request->input('heure_debut');
    $heure_fin = $request->input('heure_fin');
    $prix = $request->input('prix');

    // Validation date_debut and date_fin
    if (!empty($date_fin) && Carbon::parse($date_debut)->gt(Carbon::parse($date_fin))) {
        Toastr::error('La date de début doit être inférieure à la date de fin.');
        return redirect()->back();
    }

    if (!empty($image)) {
        $filename = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $data['image'] = url('storage/uploads/events') . '/' . $filename;
        $image->storeAs('uploads/events/', $filename, ['disk' => 'public']);
    }

    if (!empty($fichier)) {
        $fichierFilename = hexdec(uniqid()) . '.' . $fichier->getClientOriginalExtension();
        $data['fichier'] = url('storage/uploads/events') . '/' . $fichierFilename;
        $fichier->storeAs('uploads/events/', $fichierFilename, ['disk' => 'public']);
    }

    if (!empty($heure_debut)) {
        $data['heure_debut'] = Carbon::createFromFormat('g:i A', $heure_debut)->format('H:i');
    }

    if (!empty($heure_fin)) {
        $data['heure_fin'] = Carbon::createFromFormat('g:i A', $heure_fin)->format('H:i');
    }

    $event = Evenement::create($data);

    if (!empty($partenaireImages)) {
        foreach ($partenaireImages as $partenaireImage) {
            $partenaireFilename = hexdec(uniqid()) . '.' . $partenaireImage->getClientOriginalExtension();
            $partenairePath = url('storage/uploads/partenaires/') . '/' . $partenaireFilename;
            $partenaireImage->storeAs('uploads/partenaires/', $partenaireFilename, ['disk' => 'public']);

            EvenementPartenaire::create([
                'evenement_id' => $event->id,
                'image' => $partenairePath,
            ]);
        }
    }

    Toastr::success('Événement ajouté avec succès!', 'Succès');
    return redirect()->intended(route('events.home'));
}

    public function edit($id)
    {
        $event = Evenement::with('partenaires')->findOrFail($id);
        return view('pages.events.edit', compact('event'));
    }


    public function show($id)
    {
        $event = Evenement::with(['participants', 'partenaires'])->find($id);
    return view('pages.events.participant')->with('event', $event);
    }
    
    public function update($id, Request $request)
    {
        $data = $request->except(['pay', 'partenaires', 'existing_partenaires']);
        $image = $request->file('image');
        $fichier = $request->file('fichier');
        $partenaireImages = $request->file('partenaires');
        $existingPartenaires = $request->input('existing_partenaires', []);
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');
        $heure_debut = $request->input('heure_debut');
        $heure_fin = $request->input('heure_fin');
        $prix = $request->input('prix');
        $event = Evenement::where('id', $id)->first();
    
        // Validation date_debut and date_fin
        if (!empty($date_fin) && Carbon::parse($date_debut)->gt(Carbon::parse($date_fin))) {
            Toastr::error('La date de début doit être inférieure à la date de fin.');
            return redirect()->back();
        }

    
        if (!empty($image)) {
            if (Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
    
            $filename = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $data['image'] = url('storage/uploads/events') . '/' . $filename;
            $image->storeAs('uploads/events/', $filename, ['disk' => 'public']);
        }
    
        if (!empty($fichier)) {
            if (Storage::disk('public')->exists($event->fichier)) {
                Storage::disk('public')->delete($event->fichier);
            }
    
            $fichierFilename = hexdec(uniqid()) . '.' . $fichier->getClientOriginalExtension();
            $data['fichier'] = url('storage/uploads/events') . '/' . $fichierFilename;
            $fichier->storeAs('uploads/events/', $fichierFilename, ['disk' => 'public']);
        }
    
        $data['date_debut'] = Carbon::parse($date_debut)->format('Y-m-d');
        $data['date_fin'] = !empty($date_fin) ? Carbon::parse($date_fin)->format('Y-m-d') : null;
        $data['heure_debut'] = Carbon::parse($heure_debut)->format('H:i');
        $data['heure_fin'] = !empty($heure_fin) ? Carbon::parse($heure_fin)->format('H:i') : null;
    
        $event->update($data);
         // Gérer les nouveaux partenaires ajoutés
    if (!empty($partenaireImages)) {
        foreach ($partenaireImages as $partenaireImage) {
            $partenaireFilename = hexdec(uniqid()) . '.' . $partenaireImage->getClientOriginalExtension();
            $partenairePath = url('storage/uploads/partenaires') . '/' .$partenaireFilename;
            $partenaireImage->storeAs('uploads/partenaires/', $partenaireFilename, ['disk' => 'public']);

            EvenementPartenaire::create([
                'evenement_id' => $event->id,
                'image' => $partenairePath,
            ]);
        }
        
    }
    
        Toastr::success('Événement mis à jour avec succès!', 'Succès');
    
        return redirect()->intended(route('events.home'));
    }
    


    public function delete($id)
    {
        $event = Evenement::where('id', $id)->first();

        $split = explode('/', $event->image);

        $filename = end($split);

        $path = storage_path("app/public/uploads/events/$filename");

        if (File::exists($path)) {
            File::delete($path);
        }

        $event->delete();

        Toastr::success('Évenement supprimé avec succès!', 'Success');

        return redirect()->intended(route('events.home'));
    }
    

    public function deleteParticipant($id)
    {
        Participant::where('id', $id)->delete();

        Toastr::success('Participant supprimé avec succès!', 'Success');

        return back();
    }

    public function showParticipant($id)
    {
        $participant = Participant::findOrFail($id);

        return view('pages.events.showParticipant', compact('participant'));
    }

    /**
     * Supprime l'image associée à l'événement.
     *
     * @param  \App\Models\Evenement  $event
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(Evenement $event)
    {
        if (Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->update(['image' => null]);

        return back()->with('success', 'Image supprimée avec succès.');
    }

     /**
     * Supprime le fichier associé à l'événement.
     *
     * @param  \App\Models\Evenement  $event
     * @return \Illuminate\Http\Response
     */
    public function deleteFile(Evenement $event)
    {
        if (Storage::disk('public')->exists($event->fichier)) {
            Storage::disk('public')->delete($event->fichier);
        }

        $event->update(['fichier' => null]);

        return back()->with('success', 'Fichier supprimé avec succès.');
    }

    /**
     * Supprime un partenaire associé à l'événement.
     *
     * @param  \App\Models\Evenement  $event
     * @param  \App\Models\EvenementPartenaire  $partenaire
     * @return \Illuminate\Http\Response
     */
    public function deletePartenaire(Evenement $event, EvenementPartenaire $partenaire)
    {
        if (Storage::disk('public')->exists($partenaire->image)) {
            Storage::disk('public')->delete($partenaire->image);
        }

        $partenaire->delete();

        return back()->with('success', 'Partenaire supprimé avec succès.');
    }


}
