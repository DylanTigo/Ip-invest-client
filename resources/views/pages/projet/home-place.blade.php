@extends('layouts.main')

@section('title', 'Projets - ' . config('app.name'))

@section('style')
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
                            <h4 class="mb-sm-0 font-size-18">Projets d'une ville</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Projets</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Liste des projets de la ville "{{ $ville }}"</h4>

                            <div class="actions d-flex align-items-center">
                                <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($secteurs as $secteur)
                    @if (count($secteur->projets) > 0)
                        <div class="card bg-primary">
                            <div class="card-body p-2 d-flex justify-content-between align-items-center text-white">
                                <h4 class="card-title m-0 text-white"><i class="mdi mdi-chevron-right me-1"></i>
                                    {{ $secteur->libelle }}</h4>
                                <h4 class="card-title m-0 text-white">{{ count($secteur->projets) }} projet(s)</h4>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($secteur->projets as $projet)
                                <div class="col-lg-6 col-xl-4">
                                    <div class="card"
                                        style="border-radius: 0.75rem; box-shadow: 0 -0.25rem 3.5rem rgb(18 38 63 / 26%); cursor: pointer;"
                                        onclick="redirectTo('{{ route('projet.details', ['id' => $projet->id]) }}')">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-4">
                                                    <div class="avatar-md">
                                                        <span
                                                            class="avatar-title rounded-circle bg-light text-danger font-size-16">
                                                            <a
                                                                href="{{ route('projet.details', ['id' => $projet->id]) }}">
                                                                <img class="rounded-circle avatar-sm"
                                                                    src="{{ $projet->logo ? $projet->logo : asset('assets/images/projet.jpg') }}"
                                                                    alt="" height="30">
                                                            </a>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="flex-grow-1 overflow-hidden">
                                                    <h5 class="text-truncate font-size-15">
                                                        <a href="{{ route('projet.details', ['id' => $projet->id]) }}"
                                                            class="text-decoration-none">
                                                            {{ $projet->intitule }}
                                                        </a>
                                                    </h5>
                                                    <p class="font-size-14 fw-bolder">{{$projet->financement}} XAF</p>
                                                    <hr>
                                                    <div class="text-muted fw-bolder">
                                                        {{-- <p>
                                                            <i class="mdi mdi-domain me-1"></i>
                                                            {{ $projet->secteur_data->libelle }}
                                                        </p> --}}
                                                        <p class="mb-0 text-truncate">
                                                            <i class="mdi mdi-lightbulb-multiple me-1"></i>
                                                            {{ $projet->avancement_complet }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="px-4 py-3 border-top">
                                            <div class="d-flex justify-content-between align-items-center w-100">
                                                <div>
                                                    <i class="bx bx-calendar me-1"></i> Crée
                                                    {{ Carbon\Carbon::parse($projet->created_at)->diffForHumans() }}
                                                </div>
                                                <span class="badge bg-primary p-2">{{ $projet->etat_complet }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @include('partials.footer')
    </div>
@endsection

@section('script')
@endsection
