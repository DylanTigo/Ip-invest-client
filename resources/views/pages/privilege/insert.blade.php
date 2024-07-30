@extends('layouts.main')

@section('title', 'Ajouter un privilège - ' . config('app.name'))

@section('style')
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- Datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection


@section('content')
@php
    $privileges = DB::table('privileges')
        ->where('user', auth()->user()->id)
        ->get();
@endphp
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Privilèges</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Privilèges</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Ajouter un privilège</h4>

                            <form action="{{ route('store.writer') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label>Utilisateur</label>
                                    <select class="form-select" name="user">
                                        <option disabled hidden selected></option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->nom_complet }} -
                                                {{ $user->role_data->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Modules</label>
                                    <select class="form-select" name="module">
                                        <option disabled hidden selected></option>
                                        @foreach ($modules as $item)
                                            <option value="{{ $item->id }}">{{ $item->module }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="w-75 d-flex justify-content-around align-items-center mx-auto my-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="consulter" id="consulter"
                                            value="1">
                                        <label class="form-check-label">Consulter</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="modifier" id="modifier"
                                            value="1">
                                        <label class="form-check-label">Modifier</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="ajouter" id="ajouter"
                                            value="1">
                                        <label class="form-check-label">Ajouter</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="supprimer" id="supprimer"
                                            value="1">
                                        <label class="form-check-label">Supprimer</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" onClick="toggle(this)"
                                            id="inlineCheckbox1" value="all">
                                        <label class="form-check-label" for="inlineCheckbox1">Tout</label>
                                    </div>
                                </div>

                                @if (auth()->user()->role == 1 || auth()->user()->role == 5)
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary w-md">Ajouter</button>
                                    </div>
                                @else
                                    @foreach ($privileges as $privilege)
                                        @if ($privilege->module == 10 && $privilege->ajouter == 1)
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary w-md">Ajouter</button>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                            </form>


                        </div>
                    </div>
                </div>


            </div>
        </div>

        @include('partials.footer')
    </div>
@endsection

@section('script')
    {{-- <script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

    <!-- Required datatable js -->
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <script>
        function toggle(source) {
            supprimer = document.getElementById('supprimer');
            ajouter = document.getElementById('ajouter');
            consulter = document.getElementById('consulter');
            modifier = document.getElementById('modifier');

            supprimer.checked = source.checked;
            ajouter.checked = source.checked;
            consulter.checked = source.checked;
            modifier.checked = source.checked;

        }
    </script>

    <!-- Responsive examples -->
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}


@endsection
