<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\EventMail;
use App\Models\Evenement;
use App\Models\Participant;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EvenementController extends Controller
{
    public function index()
    {
        $events = Evenement::get();
        $month = Evenement::whereMonth('date_debut', '=', \Carbon\Carbon::now()->month)->get();

        return $this->sendResponse(['all' => $events, 'month' => $month], 'All events');
    }

    public function new()
    {
        $events = Evenement::latest()->take(6)->get();
        return $this->sendResponse($events, 'Latest events');
    }

        public function participer($id, Request $request)
    {
        $data = $request->input();
        $data['evenement'] = $id;

        $user = Participant::where("email", $request->email)->where("evenement", $id)->first();

        if (!empty($user)) {
            $user->places += (int)$request->places;
            $user->save();
        } else {
            $user = Participant::create($data);
        }

        $event = Evenement::find($id);

        $message = 'Participation done';

        try {
            Mail::to($user->email)
                ->queue(new EventMail(
                    $event->toArray(),
                    $user->toArray()
                ));
        } catch (\Throwable $th) {
            $message = 'Impossible d\'envoyer un mail car l\'email n\'existe pas.';
        }

        return $this->sendResponse($user, $message);
    }


    public function downloadFile($id, Request $request)
    {
        $fichier = $request->file('fichier');
        $event = Evenement::find($id);

        if (!empty($fichier)) {
            $fichierFilename = hexdec(uniqid()) . '.' . $fichier->getClientOriginalExtension();
            $data['fichier'] = url('storage/uploads/events') . '/' . $fichierFilename;
            $fichier->storeAs('uploads/events/', $fichierFilename, ['disk' => 'public']);
        }

        $event->save();

        return $this->show($id);
    }

    public function checkSeat($id, Request $request)
    {
        $data = $request->input();

        $event = Evenement::where('id', $id)->first();

        if ($data['places'] > ($event->places - $event->total_reserve)) {
            return $this->sendError("Nombre insuffisant de places !", [], 500);
        }

        return $this->sendResponse(null, 'Seat OK');
    }

    public function show($id)
    {
        //$event = Evenement::where('id', $id)->first();
        $event = Evenement::with( 'partenaires')->find($id);
        return $this->sendResponse($event, 'One event');
    }
}
