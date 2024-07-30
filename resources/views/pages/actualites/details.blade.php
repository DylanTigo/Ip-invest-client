@extends('layouts.main')

@section('title', 'Actualités - ' . config('app.name'))

@section('style')
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- Datatable -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endsection


@section('content')
    @php
    $privileges = DB::table('privileges')
        ->where('user', Auth::user()->id)
        ->get();
    @endphp

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Actualités</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Actualités</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="actions d-flex align-items-center">
                                @if (auth()->user()->role == 1)
                                    <a href="{{ route('actualites.edit', [$type, $actualite->id, $idPS]) }}"
                                    class="btn btn-sm btn-warning me-2">Modifier</a>
                                    <a href="{{ route('actualites.delete', [$type, $actualite->id, $idPS]) }}"
                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                        class="btn btn-sm btn-danger me-2">Supprimer</a>
                                @else
                                    @foreach ($privileges as $privilege)

                                        @if ($privilege->module == 14 && $privilege->modifier == 1)
                                            <a href="{{ route('actualites.edit', [$type, $actualite->id, $idPS]) }}"
                                                class="btn btn-sm btn-warning me-2">Modifier</a>
                                        @endif

                                        @if ($privilege->module == 14 && $privilege->supprimer == 1)
                                            <a href="{{ route('actualites.delete', [$type, $actualite->id, $idPS]) }}"
                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                class="btn btn-sm btn-danger me-2">Supprimer</a>
                                        @endif
                                    @endforeach
                                @endif
                                <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>


                            </div>
                        </div>
                    </div>
                </div>

                {{-- @json($actualite) --}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-3">
                                    <div class="row justify-content-center">
                                        <div class="col-xl-8">
                                            <div>
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        <span class="badge bg-light font-size-12 text-muted">
                                                            @if ($actualite->secteur)
                                                                {{ $actualite->secteur_data->libelle }}
                                                            @else
                                                                <a href="{{ route('projet.details', $actualite->projet_invest->id) }}"
                                                                    class="text-decoration-none text-muted">{{ $actualite->projet_invest->intitule }}</a>
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <h4>{{ $actualite->libelle }}</h4>
                                                    <p class="text-muted mb-4"><i
                                                            class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i>
                                                        @if ($actualite->secteur)
                                                            Secteur d'activité
                                                        @else
                                                            Projet
                                                        @endif
                                                    </p>
                                                </div>

                                                <hr>
                                                <div class="d-flex justify-content-center text-center row">
                                                    <div class="col-sm-4">
                                                        <div>
                                                            <p class="text-muted mb-2">Secteur d'activité</p>
                                                            <h5 class="text-truncated-2 font-size-15">
                                                                @if ($actualite->secteur)
                                                                    {{ $actualite->secteur_data->libelle }}
                                                                @else
                                                                    {{ $actualite->projet_invest->secteur_data->libelle }}
                                                                @endif
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="text-muted mb-2">Date publication</p>
                                                            <h5 class="font-size-15">
                                                                {{ Carbon\Carbon::parse($actualite->created_at)->diffForHumans() }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="mt-4 mt-sm-0">
                                                            <p class="text-muted mb-2">Posté par </p>
                                                            <h5 class="font-size-15">{{ Auth::user()->nom }}
                                                                {{ Auth::user()->prenom }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="my-5" style="height: 20rem">
                                                    <img src="{{ $actualite->image }}" alt=""
                                                        class="img-thumbnail w-100 h-100 mx-auto d-block"
                                                        style="object-fit: cover" />
                                                </div>

                                                <hr>

                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                        <p>{!! $actualite->description !!}</p>
                                                    </div>
                                                    <hr>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>



                <!-- end row -->
            </div>
        </div>

        @include('partials.footer')
    </div>
@endsection
