@extends('emails.template', ['subject' => $data["titre"]])

@section('content')
    {!! $data['mail'] !!}
    <p style="font-size: .7rem;">
        <strong>
            <a style="font-size: .7rem; color: #cacaca; text-align: center" href="https://www.ip-investmentsa.com/newsletter?email={{ urlencode($data['email']) }}">Se désabonner de la newsletter</a>
        </strong>
    </p>
    
  @include('partials.signature')
@endsection
