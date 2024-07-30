@extends('layouts.main')

@section('title', 'Projets - ' . config('app.name'))

@section('style')
<!-- dropzone css -->
<link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

<style>
        .text-c44636 {
            color: #c44636;
        }
</style>

@endsection

@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Projets</h4>

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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card w-75">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Ajouter un projet</h4>
                            <form class="row" action="{{ route('projet.store') }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf
                                <div class="form-group col-md-6 mb-3">
                                    <label for="projectname">Nom du projet <span class="text-c44636">*</span></label>
                                    <input id="projectname" name="intitule" type="text" class="form-control">
                                    @error('intitule')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label>Secteur d'activité <span class="text-c44636">*</span></label>
                                    <select class="form-control" name="secteur">
                                        <option value="">Choisir un secteur d'activité</option>
                                        @foreach ($secteurs as $secteur)
                                        <option value="{{$secteur->id}}">{{$secteur->libelle}} </option>
                                        @endforeach
                                    </select>

                                    @error('secteur')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="projectdesc">Description <span class="text-c44636">*</span></label>
                                    <textarea class="form-control" name="description" rows="3"
                                        placeholder="Entrer la description de votre projet"></textarea>

                                    @error('description')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>



                                <div class="form-group col-md-6 mb-3">
                                    <label>Etat d'avancement <span class="text-c44636">*</span></label>
                                    <select class="form-control" name="avancement">
                                        <option value="IDEE" selected>IDEE</option>
                                        <option value="PROTOTYPE">PROTOTYPE</option>
                                        <option value="SUR_LE_MARCHE">SUR_LE_MARCHE</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="projectbudget">Besoin en
                                        financement <span class="text-c44636">*</span></label>
                                    <input id="projectbudget" name="financement" type="text"
                                        placeholder="Entrez le budget dont vous avez besoin" class="form-control">

                                    @error('financement')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label>Pays d'activité <span class="text-c44636">*</span></label>
                                    <select class="form-control" id="exampleSelectGender" name="pays_activite">
                                        <option value="Afghanistan">Afghanistan </option>
                                        <option value="Afrique_Centrale">Afrique_Centrale </option>
                                        <option value="Afrique_du_sud">Afrique_du_Sud </option>
                                        <option value="Albanie">Albanie </option>
                                        <option value="Algerie">Algerie </option>
                                        <option value="Allemagne">Allemagne </option>
                                        <option value="Andorre">Andorre </option>
                                        <option value="Angola">Angola </option>
                                        <option value="Anguilla">Anguilla </option>
                                        <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                                        <option value="Argentine">Argentine </option>
                                        <option value="Armenie">Armenie </option>
                                        <option value="Australie">Australie </option>
                                        <option value="Autriche">Autriche </option>
                                        <option value="Azerbaidjan">Azerbaidjan </option>

                                        <option value="Bahamas">Bahamas </option>
                                        <option value="Bangladesh">Bangladesh </option>
                                        <option value="Barbade">Barbade </option>
                                        <option value="Bahrein">Bahrein </option>
                                        <option value="Belgique">Belgique </option>
                                        <option value="Belize">Belize </option>
                                        <option value="Benin">Benin </option>
                                        <option value="Bermudes">Bermudes </option>
                                        <option value="Bielorussie">Bielorussie </option>
                                        <option value="Bolivie">Bolivie </option>
                                        <option value="Botswana">Botswana </option>
                                        <option value="Bhoutan">Bhoutan </option>
                                        <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                                        <option value="Bresil">Bresil </option>
                                        <option value="Brunei">Brunei </option>
                                        <option value="Bulgarie">Bulgarie </option>
                                        <option value="Burkina_Faso">Burkina_Faso </option>
                                        <option value="Burundi">Burundi </option>

                                        <option value="Caiman">Caiman </option>
                                        <option value="Cambodge">Cambodge </option>
                                        <option value="Cameroun">Cameroun </option>
                                        <option value="Canada">Canada </option>
                                        <option value="Canaries">Canaries </option>
                                        <option value="Cap_vert">Cap_Vert </option>
                                        <option value="Chili">Chili </option>
                                        <option value="Chine">Chine </option>
                                        <option value="Chypre">Chypre </option>
                                        <option value="Colombie">Colombie </option>
                                        <option value="Comores">Colombie </option>
                                        <option value="Congo">Congo </option>
                                        <option value="Congo_democratique">Congo_democratique </option>
                                        <option value="Cook">Cook </option>
                                        <option value="Coree_du_Nord">Coree_du_Nord </option>
                                        <option value="Coree_du_Sud">Coree_du_Sud </option>
                                        <option value="Costa_Rica">Costa_Rica </option>
                                        <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                                        <option value="Croatie">Croatie </option>
                                        <option value="Cuba">Cuba </option>

                                        <option value="Danemark">Danemark </option>
                                        <option value="Djibouti">Djibouti </option>
                                        <option value="Dominique">Dominique </option>

                                        <option value="Egypte">Egypte </option>
                                        <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                                        <option value="Equateur">Equateur </option>
                                        <option value="Erythree">Erythree </option>
                                        <option value="Espagne">Espagne </option>
                                        <option value="Estonie">Estonie </option>
                                        <option value="Etats_Unis">Etats_Unis </option>
                                        <option value="Ethiopie">Ethiopie </option>

                                        <option value="Falkland">Falkland </option>
                                        <option value="Feroe">Feroe </option>
                                        <option value="Fidji">Fidji </option>
                                        <option value="Finlande">Finlande </option>
                                        <option value="France">France </option>

                                        <option value="Gabon">Gabon </option>
                                        <option value="Gambie">Gambie </option>
                                        <option value="Georgie">Georgie </option>
                                        <option value="Ghana">Ghana </option>
                                        <option value="Gibraltar">Gibraltar </option>
                                        <option value="Grece">Grece </option>
                                        <option value="Grenade">Grenade </option>
                                        <option value="Groenland">Groenland </option>
                                        <option value="Guadeloupe">Guadeloupe </option>
                                        <option value="Guam">Guam </option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guernesey">Guernesey </option>
                                        <option value="Guinee">Guinee </option>
                                        <option value="Guinee_Bissau">Guinee_Bissau </option>
                                        <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                                        <option value="Guyana">Guyana </option>
                                        <option value="Guyane_Francaise ">Guyane_Francaise </option>

                                        <option value="Haiti">Haiti </option>
                                        <option value="Hawaii">Hawaii </option>
                                        <option value="Honduras">Honduras </option>
                                        <option value="Hong_Kong">Hong_Kong </option>
                                        <option value="Hongrie">Hongrie </option>

                                        <option value="Inde">Inde </option>
                                        <option value="Indonesie">Indonesie </option>
                                        <option value="Iran">Iran </option>
                                        <option value="Iraq">Iraq </option>
                                        <option value="Irlande">Irlande </option>
                                        <option value="Islande">Islande </option>
                                        <option value="Israel">Israel </option>
                                        <option value="Italie">italie </option>

                                        <option value="Jamaique">Jamaique </option>
                                        <option value="Jan Mayen">Jan Mayen </option>
                                        <option value="Japon">Japon </option>
                                        <option value="Jersey">Jersey </option>
                                        <option value="Jordanie">Jordanie </option>

                                        <option value="Kazakhstan">Kazakhstan </option>
                                        <option value="Kenya">Kenya </option>
                                        <option value="Kirghizstan">Kirghizistan </option>
                                        <option value="Kiribati">Kiribati </option>
                                        <option value="Koweit">Koweit </option>

                                        <option value="Laos">Laos </option>
                                        <option value="Lesotho">Lesotho </option>
                                        <option value="Lettonie">Lettonie </option>
                                        <option value="Liban">Liban </option>
                                        <option value="Liberia">Liberia </option>
                                        <option value="Liechtenstein">Liechtenstein </option>
                                        <option value="Lituanie">Lituanie </option>
                                        <option value="Luxembourg">Luxembourg </option>
                                        <option value="Lybie">Lybie </option>

                                        <option value="Macao">Macao </option>
                                        <option value="Macedoine">Macedoine </option>
                                        <option value="Madagascar">Madagascar </option>
                                        <option value="Madère">Madère </option>
                                        <option value="Malaisie">Malaisie </option>
                                        <option value="Malawi">Malawi </option>
                                        <option value="Maldives">Maldives </option>
                                        <option value="Mali">Mali </option>
                                        <option value="Malte">Malte </option>
                                        <option value="Man">Man </option>
                                        <option value="Mariannes du Nord">Mariannes du Nord </option>
                                        <option value="Maroc">Maroc </option>
                                        <option value="Marshall">Marshall </option>
                                        <option value="Martinique">Martinique </option>
                                        <option value="Maurice">Maurice </option>
                                        <option value="Mauritanie">Mauritanie </option>
                                        <option value="Mayotte">Mayotte </option>
                                        <option value="Mexique">Mexique </option>
                                        <option value="Micronesie">Micronesie </option>
                                        <option value="Midway">Midway </option>
                                        <option value="Moldavie">Moldavie </option>
                                        <option value="Monaco">Monaco </option>
                                        <option value="Mongolie">Mongolie </option>
                                        <option value="Montserrat">Montserrat </option>
                                        <option value="Mozambique">Mozambique </option>

                                        <option value="Namibie">Namibie </option>
                                        <option value="Nauru">Nauru </option>
                                        <option value="Nepal">Nepal </option>
                                        <option value="Nicaragua">Nicaragua </option>
                                        <option value="Niger">Niger </option>
                                        <option value="Nigeria">Nigeria </option>
                                        <option value="Niue">Niue </option>
                                        <option value="Norfolk">Norfolk </option>
                                        <option value="Norvege">Norvege </option>
                                        <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                                        <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

                                        <option value="Oman">Oman </option>
                                        <option value="Ouganda">Ouganda </option>
                                        <option value="Ouzbekistan">Ouzbekistan </option>

                                        <option value="Pakistan">Pakistan </option>
                                        <option value="Palau">Palau </option>
                                        <option value="Palestine">Palestine </option>
                                        <option value="Panama">Panama </option>
                                        <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee
                                        </option>
                                        <option value="Paraguay">Paraguay </option>
                                        <option value="Pays_Bas">Pays_Bas </option>
                                        <option value="Perou">Perou </option>
                                        <option value="Philippines">Philippines </option>
                                        <option value="Pologne">Pologne </option>
                                        <option value="Polynesie">Polynesie </option>
                                        <option value="Porto_Rico">Porto_Rico </option>
                                        <option value="Portugal">Portugal </option>

                                        <option value="Qatar">Qatar </option>

                                        <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                                        <option value="Republique_Tcheque">Republique_Tcheque </option>
                                        <option value="Reunion">Reunion </option>
                                        <option value="Roumanie">Roumanie </option>
                                        <option value="Royaume_Uni">Royaume_Uni </option>
                                        <option value="Russie">Russie </option>
                                        <option value="Rwanda">Rwanda </option>

                                        <option value="Sahara Occidental">Sahara Occidental </option>
                                        <option value="Sainte_Lucie">Sainte_Lucie </option>
                                        <option value="Saint_Marin">Saint_Marin </option>
                                        <option value="Salomon">Salomon </option>
                                        <option value="Salvador">Salvador </option>
                                        <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                                        <option value="Samoa_Americaine">Samoa_Americaine </option>
                                        <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
                                        <option value="Senegal">Senegal </option>
                                        <option value="Seychelles">Seychelles </option>
                                        <option value="Sierra Leone">Sierra Leone </option>
                                        <option value="Singapour">Singapour </option>
                                        <option value="Slovaquie">Slovaquie </option>
                                        <option value="Slovenie">Slovenie</option>
                                        <option value="Somalie">Somalie </option>
                                        <option value="Soudan">Soudan </option>
                                        <option value="Sri_Lanka">Sri_Lanka </option>
                                        <option value="Suede">Suede </option>
                                        <option value="Suisse">Suisse </option>
                                        <option value="Surinam">Surinam </option>
                                        <option value="Swaziland">Swaziland </option>
                                        <option value="Syrie">Syrie </option>

                                        <option value="Tadjikistan">Tadjikistan </option>
                                        <option value="Taiwan">Taiwan </option>
                                        <option value="Tonga">Tonga </option>
                                        <option value="Tanzanie">Tanzanie </option>
                                        <option value="Tchad">Tchad </option>
                                        <option value="Thailande">Thailande </option>
                                        <option value="Tibet">Tibet </option>
                                        <option value="Timor_Oriental">Timor_Oriental </option>
                                        <option value="Togo">Togo </option>
                                        <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                                        <option value="Tristan da cunha">Tristan de cuncha </option>
                                        <option value="Tunisie">Tunisie </option>
                                        <option value="Turkmenistan">Turmenistan </option>
                                        <option value="Turquie">Turquie </option>

                                        <option value="Ukraine">Ukraine </option>
                                        <option value="Uruguay">Uruguay </option>

                                        <option value="Vanuatu">Vanuatu </option>
                                        <option value="Vatican">Vatican </option>
                                        <option value="Venezuela">Venezuela </option>
                                        <option value="Vierges_Americaines">Vierges_Americaines </option>
                                        <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                                        <option value="Vietnam">Vietnam </option>

                                        <option value="Wake">Wake </option>
                                        <option value="Wallis et Futuma">Wallis et Futuma </option>

                                        <option value="Yemen">Yemen </option>
                                        <option value="Yougoslavie">Yougoslavie </option>

                                        <option value="Zambie">Zambie </option>
                                        <option value="Zimbabwe">Zimbabwe </option>
                                    </select>

                                    @error('pays_activite')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label>Ville d'activité <span class="text-c44636">*</span></label>
                                    <input id="ville_activite" name="ville_activite" type="text" class="form-control"
                                        placeholder="Entrez la ville">

                                    @error('ville_activite')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="taux_rentabilite">Taux de
                                        rentabilité <span class="text-c44636">*</span></label>
                                    <input id="taux_rentabilite" name="taux_rentabilite" type="text"
                                        class="form-control">

                                    @error('taux_rentabilite')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="duree">Durée du projet (en mois) <span class="text-c44636">*</span>
                                    </label>
                                    <input id="duree" name="duree" type="text" class="form-control">

                                    @error('duree')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="delai_recup">Délai de recupération (en
                                        mois) <span class="text-c44636">*</span></label>
                                    <input id="delai_recup" name="delai_recup" type="text" class="form-control">

                                    @error('delai_recup')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12 mb-3">
                                    <label for="ca_previsionnel">Chiffre d'affaires
                                        prévisionnel <span class="text-c44636">*</span></label>
                                    <input id="ca_previsionnel" name="ca_previsionnel" type="text" class="form-control">

                                    @error('ca_previsionnel')
                                    <span class="text-danger"> {{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="logo-projet">Logo <span class="text-c44636">*</span></label>
                                    <input type="file" accept="image/*" name="logo" class="form-control" id="logo-projet">
                                </div>

                                <div class="form-group col-md-6 mb-3">
                                    <label for="medias-projet">Fichiers joints <span class="text-c44636">*</span></label>
                                    <input type="file" accept="application/pdf" name="medias[]" class="form-control" multiple id="medias-projet">
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>

    @include('partials.footer')
</div>
@endsection

@section('script')
{{-- <script type="text/javascript" src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}

<!-- dropzone plugin -->
<script type="text/javascript" src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>


@endsection