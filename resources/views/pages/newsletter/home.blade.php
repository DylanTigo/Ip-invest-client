@extends('layouts.main')

@section('title', 'Newsletters')

@section('style')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                            <h4 class="mb-sm-0 font-size-18">Newsletters</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Newsletters</li>
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
                                    <h4 class="card-title">Liste des newsletters</h4>
                                    <div class="actions d-flex align-items-center">
                                        <a href="{{ route('newsletter.add') }}" class="btn btn-sm btn-primary me-2">
                                            Nouvelle newsletter
                                        </a>
                                        @if (Auth::user()->role == 1)
                                            <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 15 && $privilege->ajouter == 1)
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="reload()">Actualiser</button>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Crée le</th>
                                            <th class="text-center">Etat</th>
                                            <th style="width: 10%"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($newsletters as $newsletter)
                                            <tr>
                                                <td>
                                                    <strong>{{ $newsletter->titre }}</strong>
                                                </td>
                                                <td style="width: 20%">
                                                    {{ \Carbon\Carbon::parse($newsletter->created_at)->format('d/m/y \à h:i') }}
                                                </td>
                                                <td class="text-center" style="width: 20%">
                                                    @if ($newsletter->send)
                                                        <span class="badge bg-success text-white p-2">Envoyé</span>
                                                    @else
                                                        <span class="badge bg-danger text-white p-2">Non envoyé</span>
                                                    @endif
                                                </td>
                                                <td style="width: 10%">
                                                        <!-- <a href="{{ route('newsletter.sendme', $newsletter->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="mdi mdi-send-circle-outline"></i>
                                                        </a> -->
                                                    @if (Auth::user()->role == 1)
                                                        <a href="{{ route('newsletter.edit', $newsletter->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="bx bx-edit"></i>
                                                        </a>
                                                        <a href="{{ route('newsletter.send', $newsletter->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="mdi mdi-email-send-outline"></i>
                                                        </a>
                                                        <a href="{{ route('newsletter.delete', $newsletter->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </a>
                                                    @else
                                                        @foreach ($privileges as $privilege)

                                                            @if ($privilege->module == 15 && $privilege->modifier == 1)
                                                                <a href="{{ route('newsletter.edit', $newsletter->id) }}"
                                                                    class="btn btn-sm btn-warning">
                                                                    <i class="bx bx-edit"></i>
                                                                </a>
                                                                <a href="{{ route('newsletter.send', $newsletter->id) }}"
                                                                    class="btn btn-sm btn-info">
                                                                    <i class="mdi mdi-email-send-outline"></i>
                                                                </a>
                                                            @endif

                                                            @if ($privilege->module == 15 && $privilege->supprimer == 1)
                                                                <a href="{{ route('newsletter.delete', $newsletter->id) }}"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                                    class="btn btn-sm btn-danger">
                                                                    <i class="bx bx-trash"></i>
                                                                </a>
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
                    </div>
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
