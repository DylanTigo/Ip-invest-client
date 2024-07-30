@extends('layouts.main')

@section('title', 'Slides - ' . config('app.name'))

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
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="card-title">Liste des différentes slides</h4>
                                    <div class="actions d-flex align-items-center">
                                        @if (auth()->user()->role == 1)
                                            <a href="{{ route('slider.add') }}" class="btn btn-sm btn-primary me-2">Nouvelle
                                                slide</a>
                                        @else
                                            @foreach ($privileges as $privilege)
                                                @if ($privilege->module == 12 && $privilege->ajouter == 1)
                                                    <a href="{{ route('slider.add') }}"
                                                        class="btn btn-sm btn-primary me-2">Nouvelle
                                                        slide</a>
                                                @endif
                                            @endforeach
                                        @endif
                                        <button class="btn btn-sm btn-primary" onclick="reload()">Actualiser</button>
                                    </div>
                                </div>

                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif


                                <table id="datatable" class="table table-bordered align-middle w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col" width="5%">SL</th>
                                            <th scope="col" width="15%">Titre</th>
                                            <th scope="col" width="25%">Description</th>
                                            <th scope="col" width="15%" class="text-center">Image</th>
                                            <th scope="col" width="15%" class="text-center"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php($i = 1)
                                        @foreach ($sliders as $slider)
                                            <tr>
                                                <th scope="row">{{ $i++ }}</th>
                                                <td>{{ $slider->title }}</td>
                                                <td style="word-break: break-all;">{{ $slider->description }}</td>
                                                <td class="text-center">
                                                    <img class="shadow rounded" src="{{ asset($slider->image) }}"
                                                        style="height:80px; width: 80px;">
                                                </td>
                                                <td class="text-center">
                                                    @if (auth()->user()->role == 1)
                                                        <a href="{{ url('slider/edit/' . $slider->id) }}"
                                                            class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                                        <a href="{{ url('slider/delete/' . $slider->id) }}"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                            class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></a>
                                                    @else
                                                        @foreach ($privileges as $privilege)
                                                            @if ($privilege->module == 12 && $privilege->modifier == 1)
                                                                <a href="{{ url('slider/edit/' . $slider->id) }}"
                                                                    class="btn btn-sm btn-warning"><i
                                                                        class="bx bx-edit"></i></a>
                                                            @endif
                                                            @if ($privilege->module == 12 && $privilege->supprimer == 1)
                                                                <a href="{{ url('slider/delete/' . $slider->id) }}"
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

    <!-- Responsive examples -->
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script type="text/javascript" src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

    {{-- <script type="text/javascript" src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script> --}}
@endsection
