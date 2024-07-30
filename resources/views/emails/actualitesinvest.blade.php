@extends('emails.template', ['subject' => 'Nouvelle actualité'])

@section('content')
    <p>Cher <strong>{{ $investisseur['nom_complet'] }}</strong>,</p>
    <p>Découvrez de nouvelles actualités pour vous en cliquant sur le lien <a
            href="https://invest--partners.com/investor/projets/{{ $projet['id'] }}">https://invest--partners.com</a>
    </p>
    <p><strong>Construire Ensemble !</strong></p>
    @include('partials.signature')
@endsection
