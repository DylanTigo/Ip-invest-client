<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NewsletterMail;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        NewsletterMail::updateOrCreate([
            'email' => $request->email
        ], []);

        return $this->sendResponse(null, 'Newsletter mail');
    }

    public function update(Request $request)
    {
        if ($request->remove) {
            NewsletterMail::where('email', $request->email)->detele();
        } else {
            NewsletterMail::updateOrCreate([
                'email' => $request->email
            ], []);
        }

        return $this->sendResponse(null, 'Newsletter mail');
    }
}
