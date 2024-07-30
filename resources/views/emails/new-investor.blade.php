@extends('emails.template', ['subject' => 'Bienvenue chez IP Investment SA'])

@section('content')
    <p>
        Bienvenue sur notre plateforme <strong>'TCHOUAH'</strong> en qualité
        <strong>{{ $user['role'] == 3 ? 'de porteur de projet' : 'd\'investisseur' }}</strong>!
    </p>
    <p>
        Voici vos identifiants : <br/>
        <strong>Email: </strong> {{ $user['email'] }} <br/>
        <strong>Mot de passe: </strong> {{ $user['pass'] }}
    </p>
    <p>
        Connectez-vous maintenant !
        (<strong><a href="https://www.ip-investmentsa.com/auth">https://www.ip-investmentsa.com/</a>.</strong>).
    </p>

    <p><strong><em>Construire Ensemble!</em></strong></p>
    @include('partials.signature')
@endsection
