@extends('emails.template', ['subject' => 'Avis de réception de votre paiement sur IP Investment SA'])

@section('content')
    @if ($transaction['is_client'])
        <p>Cher <strong>{{ $transaction['user']['nom'] }}</strong>,</p>
    @else
        <p>Cher <strong>{{ $transaction['participant']['nom'] }}</strong>,</p>
    @endif
    <p>
        Nous affirmons avoir perçu un montant de <strong>{{ $transaction['montant'] }} FCFA</strong>
        @switch($transaction['type'])
            @case('PROFIL')
                lors de la mise à jour de votre plage d'investissement.
            @break

            @case('EVENT')
                lors de votre enregistrement à un évenement.
            @break

            @default
                lors de votre inscription sur notre plateforme.
        @endswitch
    </p>
    <p>
        <strong>Merci pour votre confiance et à bientôt sur <a href="https://www.ip-investmentsa.com">IP Investment SA</a></strong>.
    </p>

    <p><strong><em>Construire Ensemble!</em></strong></p>
    @include('partials.signature')
@endsection
