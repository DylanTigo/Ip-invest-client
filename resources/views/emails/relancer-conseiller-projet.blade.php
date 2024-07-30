@extends('emails.template', ['subject' => 'Relance sur les projets en attente'])

@section('content')
    <p>
        Vous avez
        <a href="{{ route('projet.home_etat', 'ATTENTE') }}">
            <strong>{{ $data['count'] }} projet(s)</strong>
        </a>
        soumis et en attente d'approbation depuis {{ $data['days'] }} jours. Veuillez SVP le(s) prendre en considération. 
    </p>
    @include('partials.signature')
@endsection
