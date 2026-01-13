@extends('layouts.master')

@section('back')
    <a href="{{ route('predictionEdit.create') }}" class="text-white text-decoration-none d-inline-flex align-items-center gap-1 small back-link">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('head', __('predictionEdit.page_title'))

@section('predictionEdit-active', 'active')

@section('body')

    <script>
        $(document).ready(function() {
            
            //football control
            $("#football-form").submit(function(event) {

                const quote_1Required = @json('1.01'); 
                const quote_XRequired = @json('1.01');
                const quote_2Required = @json('1.01');
                const result_Required = @json('0');
                var competition = $("input[name='competition']").val();
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
                var status = $("input[name='status']").val();
                var home_score = $("input[name='home_score']").val();
                var away_score = $("input[name='away_score']").val();
                var start_timeRegex = /^([0-2][0-9]|3[01])-(0[1-9]|1[0-2])-\d{4},\s([01]?[0-9]|2[0-3]):([0-5][0-9])$/;
                var seasonRegex = /^\d{2}\/\d{2}$/;
                var quoteRegex = /^([1-9]\d*(\.\d{1,2})?|1(\.0[1-9]{1,2})?)$/;
                var resultRegex =/^\d{1,2}$/;
                var error = false;


                 if (season.trim() !== "" && !seasonRegex.test(season)) {
                    event.preventDefault();
                    $("input[name='season']").val('');
                    $("input[name='season']").addClass("error-input");
                    !error && $("input[name='season']").focus();
                    error = true;
                }
                if (home_score.trim() !== "" && !resultRegex.test(home_score)) {
                    event.preventDefault();
                    $("input[name='home_score']").val('');
                    $("input[name='home_score']").addClass("error-input");
                    $("input[name='home_score']").attr("placeholder", result_Required);
                    !error && $("input[name='home_score']").focus();
                    error = true;
                }
                if (away_score.trim() !== "" && !resultRegex.test(away_score)) {
                    event.preventDefault();
                    $("input[name='away_score']").val('');
                    $("input[name='away_score']").addClass("error-input");
                    $("input[name='away_score']").attr("placeholder", result_Required);
                    !error && $("input[name='away_score']").focus();
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

                if (start_time.trim() !== "" && !start_timeRegex.test(start_time)) {
                    event.preventDefault();
                    $("input[name='start_time']").val(start_time_ex);
                    $("input[name='start_time']").addClass("error-input-val");
                    !error && $("input[name='start_time']").focus();
                    error = true;
                } else {
                    $("input[name='start_time']").removeClass("error-input-val");
                }
            })


            const stadiumsCWC = @json($stadiums_cwc);
            const citiesCWC = @json($cities_cwc);
            // Function to enable stadium autocomplete for FIFA Club World Cup
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
            if ($('#competition').val() == 'FIFA Club World Cup') {
                enableStadiumAutocompleteForCWC();
            }
        });
    </script>

    <div class="row bg-gradient-secondary justify-content-center align-items-center pt-4">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-3">

            <ul class="nav nav-tabs" id="addTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-link_auth active border-0" id="football-tab" data-bs-toggle="tab" 
                    data-bs-target="#football" type="button" role="tab">
                        {{ __('predictionEdit.football') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="authTabContent">
                <div class="tab-pane fade show active" id="football" role="tabpanel"> 

                    <form action="{{ route('predictionEdit.edit', ['predictionEdit'=>$eventFootball->id]) }}" method="GET" id="football-form">
                        @csrf
                        <input type="hidden" name="type" value="football">  
                        
                        <div class="row">
                            <div class="col-8 mb-3">
                                <input type="text" name="competition" id="competition"class="form-control custom-input-form" value="{{ $eventFootball->competition }}" disabled/>
                            </div>
                            <div class="col-4 mb-3">
                                <input type="text" name="season" class="form-control custom-input-form" placeholder="{{$eventFootball->season}}"  />
                            </div>

                        </div>
                        @php 
                            $var_disabled = $eventFootball->status == 'scheduled' ? 'disabled' : '';
                        @endphp
                        <div class="row justify-content-center">
                            <div class="col-7 mb-3">
                                <input type="text" name="home_team" id="home_team" class="form-control custom-input-form play"  value="{{$eventFootball->home_team}}" disabled/>
                            </div>
                            <div class="col-3 mb-3">
                                <input type="number" name="home_score" id="home_score" class="form-control custom-input-form play" value="{{$eventFootball->home_score}}" {{$var_disabled}}/>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-7 mb-3">
                                <input type="text" name="away_team" id="away_team" class="form-control custom-input-form play" value="{{$eventFootball->away_team}}" disabled/>
                            </div>
                            <div class="col-3 mb-3">
                                <input type="number" name="away_score" id="away_score" class="form-control custom-input-form play" value="{{$eventFootball->away_score}}" {{$var_disabled}}/>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                                <div class="col-4 mb-3">
                                    <input type="number" name="quote_1" class="form-control custom-input-form text-center play" value="{{number_format($eventFootball->quote_1, 2, '.')}}" step="0.01" autocomplete="off"/>
                                </div>
                                <div class="col-4 mb-3">
                                    <input type="number" name="quote_X" class="form-control custom-input-form text-center play" value="{{number_format($eventFootball->quote_X, 2, '.')}}" step="0.01" autocomplete="off"/>
                                </div>
                                <div class="col-4 mb-3">
                                    <input type="number" name="quote_2" class="form-control custom-input-form text-center play" value="{{number_format($eventFootball->quote_2, 2, '.')}}" step="0.01" autocomplete="off"/>
                                </div>
                        </div>

                        
                        <div class="mb-3">
                            <input type="text" name="start_time" class="form-control custom-input-form" value="{{ \Carbon\Carbon::parse($eventFootball->start_time)->translatedFormat('d-m-Y, H:i') }}"/>
                        </div>
                        

                        <div class="mb-3">
                            <input type="text" name="stadium" class="form-control custom-input-form" id="stadium" placeholder="{{$eventFootball->stadium}}"  />
                        </div>
                        <div class="row">

                            <div class="col-6 mb-3">
                                <input type="text" name="city" class="form-control custom-input-form" id="city" placeholder="{{$eventFootball->city}}"  />
                            </div>
                            <div class="col-6 mb-3">
                                <input type="text" name="country" autocomplete="off" class="form-control custom-input-form" placeholder="{{$eventFootball->country}}"  />
                            </div>
                        </div>

                         <div class="mb-3">
                            <input type="text" name="status" class="form-control custom-input-form status" value="{{$eventFootball->status}}" disabled />
                        </div>

            
                        <div class="d-grid pb-4">
                            <input type="submit" class="btn btn-warning" value="{{ __('predictionEdit.edit_button') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection