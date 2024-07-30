@extends('layouts.main')

@section('title', 'Actualités - ' . config('app.name'))

@section('style')
    <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

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
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Liste des actualités</h4>
                            <div class="actions d-flex align-items-center">
                                @if (auth()->user()->role == 1)
                                    @if ($type == 'secteur')
                                        <a href=" {{ route('actualites.add', [$type, $secteur->id]) }}"
                                            class="btn btn-sm btn-primary me-2">Ajouter une actualité</a>
                                    @else
                                        <a href=" {{ route('actualites.add', [$type, $projet->id]) }}"
                                            class="btn btn-sm btn-primary me-2">Ajouter une actualité</a>
                                    @endif
                                @else
                                    @foreach ($privileges as $privilege)
                                        @if ($privilege->module == 14 && $privilege->ajouter == 1)
                                            @if ($type == 'secteur')
                                                <a href=" {{ route('actualites.add', [$type, $secteur->id]) }}"
                                                    class="btn btn-sm btn-primary me-2">Ajouter une actualité</a>
                                            @else
                                                <a href=" {{ route('actualites.add', [$type, $projet->id]) }}"
                                                    class="btn btn-sm btn-primary me-2">Ajouter une actualité</a>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif
                                <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    @foreach ($actualites as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card rounded shadow-lg">
                                <div class="p-3">
                                    <h5><a href="{{ $item->secteur ? route('actualites.details', [$type, $item->id, $item->secteur]) : route('actualites.details', [$type, $item->id, $item->projet]) }}"
                                            class="text-decoration-none">{{ $item->libelle }}</a></h5>
                                    <p class="text-muted small mb-0">
                                        {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                                </div>

                                @if ($item->image)
                                    <div class="position-relative" style="height: 15rem">
                                        <img src="{{ $item->image }}" alt="" class="img-thumbnail w-100 h-100"
                                            style="object-fit: cover">
                                    </div>
                                @endif

                                <div class="p-3">
                                    {{-- <ul class="list-inline">
                                <li class="list-inline-item me-3">
                                    <a href="javascript: void(0);" class="text-muted">
                                        @if ($item->secteur)
                                        <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i>
                                        {{$item->secteur_data->libelle}}
                                        @else
                                        <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i>
                                        {{$item->projet_invest->intitule}}
                                        @endif
                                    </a>
                                </li>
                            </ul> --}}

                                    <p>{!! Str::limit($item->description, 100) !!}</p>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ $item->secteur ? route('actualites.details', [$type, $item->id, $item->secteur]) : route('actualites.details', [$type, $item->id, $item->projet]) }}"
                                            class="btn w-100 btn-sm btn-primary me-1">En savoir plus <i
                                                class="mdi mdi-arrow-right"></i></a>
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ $item->secteur ? route('actualites.delete', [$type, $item->id, $item->secteur]) : route('actualites.details', [$type, $item->id, $item->projet]) }}"
                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                class="btn w-100 btn-sm btn-outline-primary ms-1">Supprimer <i
                                                    class="mdi mdi-delete"></i></a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 14 && $privilege->modifier == 1)
                                                    <a href="{{ $item->secteur ? route('actualites.delete', [$type, $item->id, $item->secteur]) : route('actualites.details', [$type, $item->id, $item->projet]) }}"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                        class="btn w-100 btn-sm btn-outline-primary ms-1">Supprimer <i
                                                            class="mdi mdi-delete"></i></a>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>


                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        @include('partials.footer')
    </div>

@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
@endsection
