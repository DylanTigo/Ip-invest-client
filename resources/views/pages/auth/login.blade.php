@extends('layouts.auth')

@section('title', 'Connexion - ' . config('app.name'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            @if ($errors->has('credential'))
                <div class="alert alert-danger fade show" role="alert">
                    <i class="mdi mdi-block-helper me-2"></i>
                    {{ $errors->first('credential') }}
                </div>
            @endif
            <div class="card overflow-hidden">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-4">
                                <h5 class="text-primary">Bon retour !</h5>
                                <p>Connectez-vous pour continuer à Invests & Partners.</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="auth-logo">
                        <a href="index-2.html" class="auth-logo-light">
                            <div class="avatar-md profile-user-wid mb-4">
                                <span class="avatar-title rounded-circle bg-light">
                                    <img src="assets/images/logo-light.svg" alt="" class="rounded-circle" height="34">
                                </span>
                            </div>
                        </a>
                        <div class="avatar-md profile-user-wid mb-4">
                            <span class="avatar-title rounded-circle bg-light">
                                <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                            </span>
                        </div>
                    </div>
                    <div class="p-2">
                        <form class="form-horizontal" method="POST" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email"
                                    class="form-control {{ $errors->has('email') || $errors->has('credential') ? 'is-invalid' : '' }}"
                                    value="{{ old('email') }}" placeholder="Saisissez l'adresse e-mail">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <div class="input-group auth-pass-inputgroup">
                                    <input type="password" name="password"
                                        class="form-control {{ $errors->has('password') || $errors->has('credential') ? 'is-invalid' : '' }}"
                                        placeholder="Saisissez le mot de passe">
                                    <button class="btn btn-light" type="button" id="password-addon"><i
                                            class="mdi mdi-eye-outline"></i></button>
                                    @if ($errors->has('password'))
                                        <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-check">
                                <label class="form-check-label" for="remember-check">
                                    Se souvenir de moi
                                </label>
                            </div>

                            <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Connexion</button>
                            </div>

                            <div class="mt-4 text-center">
                                <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Vous
                                    avez oublié votre mot de passe ?</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
