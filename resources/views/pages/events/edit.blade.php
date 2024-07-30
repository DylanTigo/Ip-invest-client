@extends('layouts.main')

@section('title', 'Évènements - ' . config('app.name'))

@section('style')

    <link href="{{ asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
        type="text/css" />

@endsection

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Évènements</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ config('app.name') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Évènements</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 d-flex justify-content-start">
                        <div class="card w-75 rounded shadow">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Modifier l'événement {{ $event->libelle }}</h4>
                                <form class="row" action="{{ route('events.update', $event->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12 mb-4">
                                    <label for="projectname">Titre de l'événement <span class="text-c44636">*</span></label>
                                    <input id="projectname" name="libelle" type="text" class="form-control" value="{{ $event->libelle }}" placeholder="Titre" required>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="lieu">Lieu de l'événement <span class="text-c44636">*</span></label>
                                    <input id="lieu" name="lieu" type="text" class="form-control" value="{{ $event->lieu }}" placeholder="Lieu" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="date_debut">Date de début <span class="text-c44636">*</span></label>
                                    <div class="input-group" id="dateevent_debut">
                                        <input id="date_debut" type="text" class="form-control" name="date_debut" placeholder="dd M, yyyy*"
                                            data-date-format="yyyy-mm-dd" data-date-container='#dateevent_debut' data-provide="datepicker"
                                            data-date-autoclose="true" value="{{ \Carbon\Carbon::parse($event->date_debut)->format('Y-m-d') }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="date_fin">Date de fin</label>
                                    <div class="input-group" id="dateevent_fin">
                                        <input id="date_fin" type="text" class="form-control" name="date_fin" placeholder="dd M, yyyy"
                                            data-date-format="yyyy-mm-dd" data-date-container='#dateevent_fin' data-provide="datepicker"
                                            data-date-autoclose="true"
                                            value="{{ $event->date_fin ? \Carbon\Carbon::parse($event->date_fin)->format('Y-m-d') : '' }}">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="heure_debut">Heure de début <span class="text-c44636">*</span></label>
                                    <div class="input-group" id="heureevent_debut">
                                        <input id="heure_debut" type="text" name="heure_debut" value="{{ \Carbon\Carbon::parse($event->heure_debut)->format('H:i') }}" class="form-control" 
                                        data-provide="timepicker" required>
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline" ></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="heure_fin">Heure de fin</label>
                                    <div class="input-group" id="heureevent_fin">
                                        <input id="heure_fin" type="text" name="heure_fin" class="form-control"
                                            value="{{ $event->heure_fin ? \Carbon\Carbon::parse($event->heure_fin)->format('H:i') : '' }}" data-provide="timepicker">
                                        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Nombre de places</label>
                                    <input name="places" type="number" value="{{ $event->places }}" class="form-control" value="1" min="1">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h5 class="font-size-14 mb-3">Payant?</h5>
                                    <div>
        <input type="checkbox" id="paiement" name="paiement" switch="bool" {{ $event->prix ? 'checked' : '' }} />
        <label for="paiement" data-on-label="Oui" data-off-label="Non"></label>
    </div>
                                </div>

                                <div class="col-md-6 mb-4" id="event-prix-block">
                                    <label class="form-label">Prix <span class="text-c44636">*</span></label>
                                    <input name="prix" id="event-prix" type="number" value="{{ $event->prix }}" class="form-control" min="0" >
                                </div>
                                <div class="form-group">
                                    <label for="image">Image <span class="text-c44636">*</span></label>
                                    <input type="file" name="image" class="form-control" value="{{ $event->image }}" readonly>
                                    @if ($event->image)
                                        <div class="input-group-append">
                                            <span class="input-group-text">Image actuelle: {{ basename($event->image) }}</span>
                                        </div>
                                    @endif
                                    @if ($event->image)
                                        <div class="mt-2">
                                            <img src="{{ $event->image }}" alt="Image actuelle" style="width: 200px;">
                                            <div>
                                                    <a href="{{ route('events.events.deleteImage', $event->id) }}"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                        class="btn btn-primary waves-effect waves-light btn-sm">Supprimer
                                                        <i class="mdi mdi-trash-can ms-1"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="fichier">Fichier</label>
                                    <input type="file" name="fichier" class="form-control">
                                    @if ($event->fichier)
                                        <div class="mt-2">
                                            <a href="{{ $event->fichier }}" target="_blank">Voir le fichier actuel</a>
                                            <div>
                                                <a href="{{ route('events.events.deleteFile', $event->id) }}"
                                                    onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                    class="btn btn-primary waves-effect waves-light btn-sm">Supprimer
                                                    <i class="mdi mdi-trash-can ms-1"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12 mb-5">
                                    <label class="form-label">Description <span class="text-c44636">*</span></label>
                                    <textarea name="description" class="form-control" rows="3">{{ $event->description ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Partenaire(s)</label>
                                    <input type="file" name="partenaires[]" class="form-control" multiple>
                                    @if ($event->partenaires)
                                        <div class="mt-2">
                                            @foreach ($event->partenaires as $partenaire)
                                                <div style="display:inline-block; margin:10px;">
                                                    <img src="{{ asset('storage/uploads/partenaires/' . basename($partenaire->image)) }}" alt="Partenaire" style="width: 100px;">
                                                    <div>
                                                    <a href="{{ route('events.events.deletePartenaire', ['event' => $event->id, 'partenaire' => $partenaire->id]) }}"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer?')"
                                                        class="btn btn-primary waves-effect waves-light btn-sm">Supprimer
                                                        <i class="mdi mdi-trash-can ms-1"></i></a>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>

        @include('partials.footer')
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            if ($('#paiement').is(':checked')) {
            $('#event-prix-block').show();
            // $('input[name="prix"]').val('');
            } else {
                $('#event-prix-block').hide();
                $('input[name="prix"]').val('');
            }

            $('#paiement').on('change', (e) => {
            if ($(e.target).is(':checked')) {
                $('#event-prix-block').show();
                //$('input[name="prix"]').val('');
            } else {
                $('input[name="prix"]').val('');
                $('#event-prix-block').hide();
            }
        });



        $('[data-toggle="touchspin"]').each(function (e, t) {
            var a = $.extend({}, $(t).data());
            $(t).TouchSpin(a);
        });

        $('#date_debut').timepicker({
            minuteStep: 1,
            template: 'dropdown',
            appendWidgetTo: '#heureevent',
            showSeconds: false,
            showMeridian: false,
            defaultTime: 'current',
            icons: { up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down" }
        });

        $('#date_fin').timepicker({
            minuteStep: 1,
            template: 'dropdown',
            appendWidgetTo: '#heureevent',
            showSeconds: false,
            showMeridian: false,
            defaultTime: 'current',
            icons: { up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down" }
        });

        $('#heure_debut').timepicker({
            minuteStep: 1,
            template: 'dropdown',
            appendWidgetTo: '#heureevent',
            showSeconds: false,
            showMeridian: false,
            defaultTime: 'current',
            icons: { up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down" }
        });
        $('#heure_fin').timepicker({
            minuteStep: 1,
            template: 'dropdown',
            appendWidgetTo: '#heureevent',
            showSeconds: false,
            showMeridian: false,
            defaultTime: 'current',
            icons: { up: "mdi mdi-chevron-up", down: "mdi mdi-chevron-down" }
        });

    });
    </script>
@endsection
