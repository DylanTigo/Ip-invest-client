@extends('emails.template', ['subject' => 'Réinitialiser le mot de passe'])

@section('content')
  <p>Bonjour,</p>

  <p>Cliquez sur ce lien <a href="{{$details['url']}}">{{$details['url']}}</a> pour réinitialiser votre mot de passe </p>

  <p>Cordialement,</p>

  <p><strong>IP Investment SA</strong></p>
  @include('partials.signature')
@endsection
