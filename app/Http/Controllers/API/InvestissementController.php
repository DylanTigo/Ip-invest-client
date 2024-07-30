<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Investissement;
use App\Models\Projet;
use App\Models\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvestissementController extends Controller
{
    public function projectInvest($id)
    {
        $projets = Investissement::select(DB::raw('sum(montant) as total_investi, user, projet'))
        ->groupBy('projet')
        ->groupBy('user')
        ->where('user', $id)
        ->with(['projet_data'])
        ->latest()
        ->get();
        return $this->sendResponse($projets, 'Get project invest');
    }
}
