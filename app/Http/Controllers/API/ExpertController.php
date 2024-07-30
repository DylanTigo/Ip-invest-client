<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Expert;

class ExpertController extends Controller
{
    public function index()
    {
        $experts = Expert::where("cacher", false)->get();
        return $this->sendResponse($experts, 'App experts');
    }
}
