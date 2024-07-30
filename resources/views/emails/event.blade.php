@extends('emails.template', ['subject' => 'Particitpation à l\'événement {{ $event["libelle"] }} organisé par IP Investment SA'])

@section('content')
    <p>Cher <strong>{{ $user['nom_complet'] }}</strong>,</p>
    <p>
        Vous avez manifestez votre intérêt à participer à l'événement <strong>"{{ $event['libelle'] }}"</strong>
        organisé par IP Investment SA.
    </p>
    <p>
        Il aura lieu le {{ \Carbon\Carbon::parse($event['date_evenement'])->translatedFormat('d M Y') }} à
        {{ $event['lieu'] }}
        à parti de {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['heure_debut'])->format('H\hi') }}
    </p>
    <p><strong><em>Construire Ensemble!</em></strong></p>
    @include('partials.signature')
@endsection
