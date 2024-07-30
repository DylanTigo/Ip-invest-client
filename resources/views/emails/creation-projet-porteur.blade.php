@extends('emails.template', ['subject' => 'Accusé de réception du projet {{ $projet["intitule"] }}'])

@section('content')
    <p>Félicitations {{ $projet['user_data']['nom_complet'] }} !!!</p>
    <p>Votre projet <strong>{{ $projet['intitule'] }}</strong> a été crée avec succès.</p>
    <p>
        Une fois validé, nous vous tiendrons au fait de la conduite à tenir pour la suite.
    </p>
    <p>
        De plus, nos conseillers en investissement restent disponibles pour vous accompagner dans le cadre de
        l'aboutissement du projet.
    </p>
    <p>
        Alors, n'hésitez pas à nous contacter directement sur la plateforme <strong>TCHOUAH </strong> <a href="https://www.ip-investmentsa.com">https://www.ip-investmentsa.com</a>  ou par mail
        à l'adresse <a href="mailto:info@invest--partners.com">info@invest--partners.com</a>
    </p>
    <p>
        <strong>IP INVESTMENT SA, Construire Ensemble !</strong>
    </p>
    @include('partials.signature')
@endsection
