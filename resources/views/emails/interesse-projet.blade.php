@extends('emails.template', ['subject' => 'Nouvelle investisseur pour le projet {{ $projet["intitule"] }}'])

@section('content')
    <p>L'investisseur {{ $investisseur['nom_complet'] }} est intéressé sur le projet
        <strong>{{ $projet['intitule'] }}</strong>.
        <a href="{{ route('chat.home') }}">Discuter avec {{ $investisseur['nom_complet'] }}</a>
    </p>

    <p>Cordialement,<br /><strong>IP Investment SA</strong></p>
    @include('partials.signature')
@endsection
