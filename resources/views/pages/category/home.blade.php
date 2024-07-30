@extends('layouts.main')

@section('title', 'Experts - ' . config('app.name'))

@section('style')
    <meta name="_token" content="{{ csrf_token() }}" />

    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection


@section('content')

    @php
        $privileges = DB::table('privileges')
            ->where('user', auth()->user()->id)
            ->get();
        
        // if (auth()->user()->role != 1 || auth()->user()->role != 5) {
        $secteurs_user = DB::table('secteurs')
            ->where('user', auth()->user()->id)
            ->get();
        // }
    @endphp

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Secteurs d'activité</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Secteurs d'activité</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="card-title">Liste des secteurs d'activité</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('category.add') }}"
                                                class="btn btn-sm btn-primary me-2">Nouveau secteur d'activité</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 11 && $privilege->ajouter == 1)
                                                    <a href="{{ route('category.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouveau secteur d'activité</a>
                                                @endif
                                            @endforeach
                                        @endif

                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                @if (auth()->user()->role == 1 || auth()->user()->role == 5)
                                    <table id="datatable" class="table table-bordered align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%"></th>
                                                <th>Secteur d'activité</th>
                                                <th style="width: 30%">Conseiller</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($secteurs as $categorie)
                                                <tr>
                                                    <td>
                                                        @if (!empty($categorie->photo))
                                                            <div>
                                                                <img class="rounded-circle avatar-xs"
                                                                    src="{{ $categorie->photo }}" alt="">
                                                            </div>
                                                        @else
                                                            <div class="avatar-xs">
                                                                <span class="avatar-title rounded-circle">
                                                                    {{ strtoupper(substr($categorie->libelle, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $categorie->libelle }}</strong>
                                                    </td>
                                                    <td>{{ $categorie->conseiller_data->nom_complet ?? 'Aucun' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('actualites.home', ['secteur', $categorie->id]) }}"
                                                            class="btn btn-sm btn-info"><i
                                                                class="mdi mdi-newspaper-variant-multiple-outline"></i></a>
                                                        @if (auth()->user()->role == 1)
                                                            <a href="{{ route('category.edit', $categorie->id) }}"
                                                                class="btn btn-sm btn-warning"><i
                                                                    class="bx bx-edit"></i></a>
                                                            <a href="{{ route('category.delete', $categorie->id) }}"
                                                                onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                class="btn btn-sm btn-danger"><i
                                                                    class="bx bx-trash"></i></a>
                                                        @else
                                                            @foreach ($privileges as $privilege)
                                                                @if ($privilege->module == 11 && $privilege->modifier == 1)
                                                                    <a href="{{ route('category.edit', $categorie->id) }}"
                                                                        class="btn btn-sm btn-warning"><i
                                                                            class="bx bx-edit"></i></a>
                                                                @endif
                                                                @if ($privilege->module == 11 && $privilege->supprimer == 1)
                                                                    <a href="{{ route('category.delete', $categorie->id) }}"
                                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                        class="btn btn-sm btn-danger"><i
                                                                            class="bx bx-trash"></i></a>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table id="datatable" class="table table-bordered align-middle w-100">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%"></th>
                                                <th>Secteur d'activité</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($secteurs as $categorie)
                                                <tr>
                                                    <td>
                                                        @if (!empty($categorie->photo))
                                                            <div>
                                                                <img class="rounded-circle avatar-xs"
                                                                    src="{{ $categorie->photo }}" alt="">
                                                            </div>
                                                        @else
                                                            <div class="avatar-xs">
                                                                <span class="avatar-title rounded-circle">
                                                                    {{ strtoupper(substr($categorie->libelle, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $categorie->libelle }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('actualites.home', ['secteur', $categorie->id]) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="mdi mdi-newspaper-variant-multiple-outline"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div>
        </div>

        @include('partials.footer')
    </div>
@endsection

@section('script')
    <!-- Required datatable js -->
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>

    <!-- Responsive examples -->
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
