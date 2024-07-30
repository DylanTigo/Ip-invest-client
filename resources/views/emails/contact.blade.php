@extends('emails.template', ['subject' => 'Demande de renseignements'])

@section('content')
    <p>{{ $data['message'] }}</p>
    <p>
        Cordialement,<br /><br />
        <strong>{{ $data['nom_complet'] }}</strong>
    </p>
    
  @include('partials.signature')
@endsection
