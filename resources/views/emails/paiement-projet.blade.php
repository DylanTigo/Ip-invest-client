@extends('emails.template', ['subject' => 'Paiement des frais d\'etude du projet {{ $projet["intitule"] }}'])

@section('content')
<p>A votre attention {{ $projet['secteur_data']['conseiller_data']['nom_complet'] }},</p>
<p>Paiement de la somme de ({{ $projet['user_data']['profil_porteur']['montant'] }} XAF) effectué
    pour le projet <a
        href="{{ route('projet.details', $projet['id']) }}"><strong>{{ $projet['intitule'] }}</strong></a><br />
    Le délai pour le traitement et la publication sur le site est de 15 jours.</p>
<p><strong>Bonne chance!</strong></p>
@include('partials.signature')
@endsection
