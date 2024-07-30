@extends('emails.template', ['subject' => 'Bienvenue chez IP Investment SA'])

@section('content')
    <p>
        Félicitations ! Vous vous êtes inscrits à notre plateforme <strong>'TCHOUAH'</strong> en qualité
        <strong>{{ $user['role'] == 3 ? 'de porteur de projet' : 'd\'investisseur' }}</strong>!
    </p>
    @if ($user['role'] == 4)
        <p>
            Investissez maintenant !
            (<strong><a href="https://www.ip-investmentsa.com/projets">https://www.ip-investmentsa.com</a>.</strong>).
        </p>
    @else
        <p>
            Soumettre un projet
            (<strong><a
                    href="https://www.ip-investmentsa.com/dashboard/projets/add">https://www.ip-investmentsa.com</a>.</strong>).
        </p>
    @endif

    <p><strong><em>Construire Ensemble!</em></strong></p>
    @include('partials.signature')
@endsection
