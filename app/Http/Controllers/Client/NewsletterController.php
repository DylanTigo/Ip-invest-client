<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail as MailNewsletterMail;
use App\Models\Newsletter;
use App\Models\NewsletterMail;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::all();
        return view('pages.newsletter.home')->with('newsletters', $newsletters);
    }

    public function mails()
    {
        $mails = NewsletterMail::all();
        return view('pages.newsletter.mails')->with('mails', $mails);
    }

    public function add()
    {
        return view('pages.newsletter.add');
    }

    public function store(Request $request)
    {
        $data = [
            'titre' => $request->titre,
            'mail' => $request->mail,
        ];


        Newsletter::create($data);

        Toastr::success('Newsletter ajoutée avec succès!', 'Succès');

        return redirect()->intended(route('newsletter.home'));
    }

    public function send($id)
    {
        $newsletter = Newsletter::find($id);

        $newsletterMails = NewsletterMail::all();

        foreach ($newsletterMails as $value) {
            try {
                Mail::to($value->email)->queue(new MailNewsletterMail([
                    'email' => $value->email,
                    'mail' => $newsletter->mail,
                    'titre' => $newsletter->titre
                ]));
            } catch (\Throwable $th) {}
        }

        $newsletter->send = true;

        $newsletter->save();

        Toastr::success('Newsletter envoyée avec succès!', 'Succès');

        return redirect()->intended(route('newsletter.home'));
    }

    public function sendme($id)
    {
        $newsletter = Newsletter::find($id);

        $newsletterMails = NewsletterMail::all();

        try {
            Mail::to('gabinnana8@gmail.com')->queue(new MailNewsletterMail([
                'email' => 'gabinnana8@gmail.com',
                'mail' => $newsletter->mail,
                'titre' => $newsletter->titre
            ]));
        } catch (\Throwable $th) {}

        $newsletter->send = true;

        $newsletter->save();

        Toastr::success('Newsletter envoyée avec succès!', 'Succès');

        return redirect()->intended(route('newsletter.home'));
    }

    public function edit($id)
    {
        $newsletter = Newsletter::find($id);
        return view('pages.newsletter.edit')->with('newsletter', $newsletter);
    }

    public function show($id)
    {
        $newsletter = Newsletter::find($id);
        return view('pages.newsletter.details')->with('newsletter', $newsletter);
    }

    public function update($id, Request $request)
    {
        $data = [
            'titre' => $request->titre,
            'mail' => $request->mail,
        ];

        Newsletter::where('id', $id)->update($data);

        Toastr::success('Newsletter mise à jour avec succès!', 'Succès');

        return redirect()->intended(route('newsletter.home'));
    }

    public function delete($id)
    {
        Newsletter::where('id', $id)->delete();

        Toastr::success('Newsletter supprimée avec succès!', 'Success');

        return redirect()->intended(route('newsletter.home'));
    }

    public function deleteEmail($id)
    {
        NewsletterMail::where('id', $id)->delete();

        Toastr::success('Email supprimée avec succès!', 'Success');

        return redirect()->intended(route('newsletter.mails'));
    }
}
