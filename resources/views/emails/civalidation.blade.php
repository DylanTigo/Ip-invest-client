@extends('emails.template', ['subject' => 'Approbation du projet {{$projet["intitule"]}} par le conseiller'])

@section('content')
  <p>Bonjour Admin,</p>
  <p>J'ai trouvé le projet <a
      href="{{url('projet'). '/'. $projet['id'] }}"><strong>{{$projet["intitule"]}}</strong></a> interessant.<br />
    Je le soumets à votre appréciation pour la suite.
  </p>
  <p>
    Cordialement, <br />
    <strong>{{Auth()->user()->nom}} {{Auth()->user()->prenom}}</strong>
  </p>
  
  @include('partials.signature')
@endsection