@extends('emails.template', ['subject' => 'Validation de votre projet {{$projet["intitule"]}}'])

@section('content')
    <p> Félicitations ! Votre projet <strong>{{ $projet['intitule'] }}</strong> a retenu l'attention
        de l'équipe IP Investment SA.<br />
        Afin de rendre votre projet plus attractif, nos experts établiront avec vous les meilleures stratégies
        d'implémentation et de marketing, mais aussi d'organisation financière et managériale.<br />
        Aussi pour nous permettre de travailler à la recherche d'investisseurs grâce à votre visibilité sur la
        plateforme,
        cliquez sur ce lien (<strong><a href="https://www.ip-investmentsa.com/dashboard/projets/{{ $projet['id'] }}">
        https://www.ip-investmentsa.com/</a></strong>) et validez le
        paiement
        d'une somme de {{ $projet['user_data']['profil_porteur']['montant'] }} XAF pour les frais
        d'étude et de publication de votre projet puis commencez
        votre aventure avec IP Investment SA!</p>

    <p> <strong>Construire Ensemble!</strong></p>
    @include('partials.signature')
@endsection
