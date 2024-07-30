@extends('layouts.main')

@section('title', 'Transactions - ' . config('app.name'))

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
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Transactions</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a
                                            href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Transactions</li>
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
                                    <h4 class="card-title">Liste des transactions</h4>
                                    <div class="actions d-flex align-items-center">
                                        {{-- <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#profilInvestisseurModal">Nouveau profil</button> --}}
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                <table  id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Client</th>
                                            <th>Méthode</th>
                                            <th>Montant</th>
                                            <th>Etat</th>
                                            <th>Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td style="width: 20%">
                                                    <p class="font-size-14 mb-0">{{ $transaction->type_complet }}</p>
                                                </td>
                                                <td>
                                                    @if ($transaction->is_client)
                                                        <p class="text-muted mb-0 fw-bolder">
                                                            {{ $transaction->user->nom }}</p>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <small>{{ $transaction->user->email }}</small>
                                                            <small>{{ $transaction->user->telephone }}</small>
                                                        </div>
                                                    @else
                                                        <p class="text-muted mb-0 fw-bolder">
                                                            {{ $transaction->participant->nom }}</p>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <small>{{ $transaction->participant->email }}</small>
                                                            <small>{{ $transaction->participant->telephone }}</small>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-muted mb-0 fw-bolder">
                                                        {{ $transaction->methode_complet }}</p>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <small>compte: {{ $transaction->telephone }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$transaction->montant}} XAF
                                                </td>
                                                <td>
                                                    <span class="badge {{ $transaction->color }} p-2">
                                                        {{ $transaction->etat }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1 text-dark">@dateFormat($transaction->created_at)</h5>
                                                    <p class="text-muted mb-0">@timeFormat($transaction->created_at)</p>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('transactions.delete', $transaction->id) }}"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cette transaction ?')"
                                                        class="btn btn-sm btn-danger float-right"><i
                                                            class="bx bx-trash"></i>
                                                    </a>
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
