@extends('layouts.main')

@section('title', 'Profil des investisseurs - ' . config('app.name'))

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
                            <h4 class="mb-sm-0 font-size-18">Profil des investisseurs</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Profil des investisseurs</li>
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
                                    <h4 class="card-title">Liste des profils disponible pour un investisseurs</h4>
                                    <div class="actions d-flex align-items-center">
                                        {{-- <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                                            data-bs-target="#profilInvestisseurModal">Nouveau profil</button> --}}
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('profil.investisseur.add') }}"
                                                class="btn btn-sm btn-primary me-2">Nouveau profil</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 7 && $privilege->ajouter == 1)
                                                    <a href="{{ route('profil.investisseur.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouveau profil</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Montant minimal</th>
                                            <th>Montant maximal</th>
                                            <th>Montant abonnement</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($profils as $profil)
                                            <tr>
                                                <td>
                                                    <strong>{{ $profil->type }}</strong>
                                                </td>
                                                <td>{{ number_format($profil->montant_min, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($profil->montant_max, 0, ',', ' ') }}</td>
                                                <td>{{ number_format($profil->frais_abonnement, 0, ',', ' ') }}</td>
                                                <td>
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ route('profil.investisseur.edit', $profil->id) }}"
                                                            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                        <a href="{{ route('profil.investisseur.delete', $profil->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 7 && $privilege->modifier == 1)
                                                                <a href="{{ route('profil.investisseur.edit', $profil->id) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="bx bx-edit"></i></a>
                                                            @endif
                                                            @if ($privilege->module == 7 && $privilege->supprimer == 1)
                                                                <a href="{{ route('profil.investisseur.delete', $profil->id) }}"
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
    {{-- <script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

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

    {{-- <script type="text/javascript" src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
@endsection
