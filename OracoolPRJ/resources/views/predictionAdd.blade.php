@extends('layouts.master')

@section('back')
    <a href="{{ route('controlPanel.index') }}" class="text-white text-decoration-none d-inline-flex align-items-center gap-1 small back-link">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('head', __('predictionAdd.page_title'))

@section('predictionAdd-active', 'active')

@section('body')

    <script>
        $(document).ready(function() {
            
            let error = false;            

            //football control
            $("#football-form").submit(function(event) {
                event.preventDefault();

                const seasonRequired = @json('24/25'); 
                const quote_1Required = @json('1.01'); 
                const quote_XRequired = @json('1.01');
                const quote_2Required = @json('1.01');
                
                var season = $("input[name='season']").val();
                var home_team = $("input[name='home_team']").val();
                var away_team = $("input[name='away_team']").val();
                var start_time = $("input[name='start_time']").val();
                var start_time_ex = "{{ \Carbon\Carbon::now()->translatedFormat('d-m-Y, ') . '20:45' }}";
                var stadium = $("input[name='stadium']").val();
                var city = $("input[name='city']").val();
                var country = $("input[name='country']").val();
                var quote_1 = $("input[name='quote_1']").val();
                var quote_X = $("input[name='quote_X']").val();
                var quote_2 = $("input[name='quote_2']").val();
                var start_timeRegex = /^([0-2][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4},\s([01]?[0-9]|2[0-3]):([0-5][0-9])$/;
                var seasonRegex = /^\d{2}\/\d{2}$/;
                var quoteRegex = /^([1-9]\d*(\.\d{1,2})?|1(\.0[1-9]{1,2})?)$/;

                if (season.trim() === "") {
                    event.preventDefault();
                    $("input[name='season']").addClass("error-input");
                    !error && $("input[name='season']").focus();
                    error = true;
                } else if (!seasonRegex.test(season)) {
                    event.preventDefault();
                    $("input[name='season']").val('');
                    $("input[name='season']").addClass("error-input");
                    $("input[name='season']").attr("placeholder", seasonRequired);
                    !error && $("input[name='season']").focus();
                    error = true;
                }
                if (home_team.trim() === "") {
                    event.preventDefault();
                    $("input[name='home_team']").addClass("error-input");
                    !error && $("input[name='home_team']").focus();
                    error = true;
                }
                if (away_team.trim() === "") {
                    event.preventDefault();
                    $("input[name='away_team']").addClass("error-input");
                    !error && $("input[name='away_team']").focus();
                    error = true;
                }
                if (home_team.trim() === away_team.trim()) {
                    event.preventDefault();
                    $("input[name='home_team']").val('');
                    $("input[name='away_team']").val('');
                    $("input[name='home_team']").addClass("error-input");
                    $("input[name='away_team']").addClass("error-input");
                    !error && $("input[name='home_team']").focus();
                    error = true;
                }
                if (quote_1.trim() !== "" && !quoteRegex.test(quote_1)) {
                    event.preventDefault();
                    $("input[name='quote_1']").val(quote_1Required);
                    $("input[name='quote_1']").addClass("error-input-val");
                    !error && $("input[name='quote_1']").focus();
                    error = true;
                }
                if (quote_X.trim() !== "" && !quoteRegex.test(quote_X)) {
                    event.preventDefault();
                    $("input[name='quote_X']").val(quote_XRequired);
                    $("input[name='quote_X']").addClass("error-input-val");
                    !error && $("input[name='quote_X']").focus();
                    error = true;
                }
                if (quote_2.trim() !== "" && !quoteRegex.test(quote_2)) {
                    event.preventDefault();
                    $("input[name='quote_2']").val(quote_2Required);
                    $("input[name='quote_2']").addClass("error-input-val");
                    !error && $("input[name='quote_2']").focus();
                    error = true;
                }

                if (start_time.trim() === "") {
                    event.preventDefault();
                    $("input[name='start_time']").val(start_time_ex);
                    $("input[name='start_time']").addClass("error-input-val");
                    !error && $("input[name='start_time']").focus();
                    error = true;
                } else if (!start_timeRegex.test(start_time)) {
                    event.preventDefault();
                    $("input[name='start_time']").val(start_time_ex);
                    $("input[name='start_time']").addClass("error-input-val");
                    !error && $("input[name='start_time']").focus();
                    error = true;
                } else {
                    $("input[name='start_time']").removeClass("error-input-val");
                }
                if (stadium.trim() === "") {
                    event.preventDefault();
                    $("input[name='stadium']").val('');
                    $("input[name='stadium']").addClass("error-input");
                    !error && $("input[name='stadium']").focus();
                    error = true;
                }
                if (city.trim() === "") {
                    event.preventDefault();
                    $("input[name='city']").addClass("error-input");
                    !error && $("input[name='city']").focus();
                    error = true;
                }
                if (country.trim() === "") {
                    event.preventDefault();
                    $("input[name='country']").addClass("error-input");
                    !error && $("input[name='country']").focus();
                    error = true;
                }

                if (!error) {                
                    // Check if there are other predictions for the same match
                    $.ajax({
                        type: "GET",
                        url:  "{{ route('predictionAdd.storeAjax') }}",
                        data: {
                            home_team: $("input[name='home_team']").val(),
                            away_team: $("input[name='away_team']").val(),
                            competition: $('#competition').val()
                        },
                        success: function(response) {
                            if (response.success) {
                                document.getElementById("football-form").submit();
                            } else {
                                toastr.error(response.error);      
                                document.getElementById("football-form").reset();
                            }
                        },
                    });
                }
            })

        const teams = @json($teams);
        const countries = @json($countries);
        const cities = @json($cities);
        const stadium = @json($stadiums);
        const competitions = @json($competitions);
        const stadiumsCWC = @json($stadiums_cwc);
        const citiesCWC = @json($cities_cwc);
        

        // Initialize autocomplete for home_team and away_team
        function updateTeams() {
            const selectedCompetition = $('#competition').val();
            const availableTeams = teams[selectedCompetition] || [];

            $('#home_team').autocomplete({
                source: availableTeams,
                minLength: 2,
                select: function (event, ui) {
                    const selectedHomeTeam = ui.item.value;
                    const awayTeamOptions = availableTeams.filter(team => team !== selectedHomeTeam);

                    $('#away_team').autocomplete({
                        source: awayTeamOptions,
                        minLength: 2
                    });

                    updateHome();
                }
            });

            const country = countries[selectedCompetition];
            if (country) {
                $('#country').val(country); 
            }
        }

        // Update the home team city and stadium based on the selected home team
        function updateHome() {
            const selectedCompetition = $('#competition').val();
            const home = $("input[name='home_team']").val();

            if (selectedCompetition !== 'FIFA Club World Cup') {
                const city = cities[home];
                if (city) {
                    $('#city').val(city);  
                }

                const stadiumName = stadium[home];
                if (stadiumName) {
                    $('#stadium').val(stadiumName); 
                }

            }
        }

        function enableStadiumAutocompleteForCWC() {
            $('#stadium').autocomplete({
                source: stadiumsCWC,
                minLength: 2,
                select: function (event, ui) {
                    const selectedStadium = ui.item.value;
                    const city = citiesCWC[selectedStadium];
                    if (city) {
                        $('#city').val(city);
                    }
                }
            });
        }

        // Initialize autocomplete for away_team
        $('#competition').on('change', function () {
            updateTeams();
            updateHome();

            if ($(this).val() === 'FIFA Club World Cup') {
                enableStadiumAutocompleteForCWC();
            }
        });
        // Initialize autocomplete for home_team
        $('#home_team').on('change', updateHome);
        // Initialize the autocomplete for the competition dropdown
        updateTeams();
        updateHome();
    });
    </script>


    <div class="row bg-gradient-secondary justify-content-center align-items-center pt-4">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-3">

            <ul class="nav nav-tabs" id="addTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-link_auth active border-0" id="football-tab" data-bs-toggle="tab" 
                    data-bs-target="#football" type="button" role="tab">
                        {{ __('predictionAdd.football_tab') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="authTabContent">
                <div class="tab-pane fade show active" id="football" role="tabpanel">
                    <form action="{{ route('predictionAdd.store') }}" id="football-form" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="football">     

                        <div class="row">
                            <div class="col-8 mb-3">
                                <select name="competition" id="competition" class="form-control custom-input-form" autofocus>
                                    <option value="" disabled selected hidden >{{ __('predictionAdd.competition') }}</option>
                                    @foreach ($competitions as $competition)
                                        <option value="{{ $competition }}">{{ $competition }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <input type="text" name="season" class="form-control custom-input-form" placeholder="{{ __('predictionAdd.season') }}" value="24/25"  />
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-10 mb-3 ">
                                <input type="text" name="home_team" id="home_team" class="form-control custom-input-form play" placeholder="{{ __('predictionAdd.home_team') }}" />
                            </div>
                            <div class="col-10 mb-3">
                                <input type="text" name="away_team" id="away_team" class="form-control custom-input-form play" placeholder="{{ __('predictionAdd.away_team') }}"  />
                            </div>
                            <div class="row justify-content-center ">
                                <div class="col-3 mb-3 px-1">
                                    <input type="number" name="quote_1" class="form-control custom-input-form text-center play" value="1.01"  step="0.01" autocomplete="off"/>
                                </div>
                                <div class="col-3 mb-3 px-1 mx-3">
                                    <input type="number" name="quote_X" class="form-control custom-input-form text-center play" value="1.01" step="0.01"   autocomplete="off"/>
                                </div>
                                <div class="col-3 mb-3 px-1">
                                    <input type="number" name="quote_2" class="form-control custom-input-form text-center play" value="1.01"  step="0.01" autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="start_time" id="start_time"  class="form-control custom-input-form " value="{{ \Carbon\Carbon::now()->translatedFormat('d-m-Y, ') . '20:45' }}"  />
                        </div>
                        <div class="mb-3">
                            <input type="text" name="stadium" id="stadium" class="form-control custom-input-form" placeholder="{{ __('predictionAdd.stadium') }}"  />
                        </div>
                        <div class="row">
                        <div class="col-6 mb-3">
                            <input type="text" name="city" id="city" class="form-control custom-input-form" placeholder="{{ __('predictionAdd.city') }}"  />
                        </div>
                        <div class="col-6 mb-3">
                            <input type="text" name="country" id="country" class="form-control custom-input-form" placeholder="{{ __('predictionAdd.country') }}" />
                        </div>
                        </div>
                        <div class="d-grid pb-4">
                            <input type="submit" class="btn btn-primary" value="{{ __('predictionAdd.add_button') }}" id="predictionAdd-action">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection