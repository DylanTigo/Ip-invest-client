@extends('emails.template', ['subject' => 'Accusé de réception du paiement des frais de votre {{$projet["intitule"]}}'])

@section('content')
  <p>Félicitations <strong>{{$projet['user_data']['nom_complet']}}</strong>! Votre paiement a été approuvé.<br/>
  Votre projet en bonne et due forme sera visible par tous les investisseurs dans un délai de <strong>15 jours</strong>.<br/>
  N'hésitez pas à échanger avec votre conseiller sur son évolution.</p>
  <p><strong><em>Construire Ensemble!</em></strong></p>
  @include('partials.signature')
@endsection
