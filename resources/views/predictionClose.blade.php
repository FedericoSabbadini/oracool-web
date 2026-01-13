@extends('layouts.master')

@section('back')
<a href="{{ route('predictionClose.create') }}" class="text-white text-decoration-none d-inline-flex align-items-center gap-1 small back-link">
    <i class="bi bi-arrow-left"></i>
</a>
@endsection

@section('head', __('predictionClose.page_title'))

@section('predictionClose-active', 'active')

@section('body')

    <script>
        $(document).ready(function() {
            
            //football control
            $("#football-form").submit(function(event) {

                const result_Required = @json('0');
                var home_score = $("input[name='home_score']").val();
                var away_score = $("input[name='away_score']").val();
                var resultRegex =/^\d{1,2}$/;
                var error = false;
                
                if (home_score.trim() !== "" && !resultRegex.test(home_score)) {
                    event.preventDefault();
                    $("input[name='home_score']").val(result_Required);
                    $("input[name='home_score']").addClass("error-input-val");
                    !error && $("input[name='home_score']").focus();
                    error = true;
                } else if (home_score.trim() === "") {
                    event.preventDefault();
                    $("input[name='home_score']").val(result_Required);
                    $("input[name='home_score']").addClass("error-input-val");
                    !error && $("input[name='home_score']").focus();
                    error = true;
                }
                if (away_score.trim() !== "" && !resultRegex.test(away_score)) {
                    event.preventDefault();
                    $("input[name='away_score']").val(result_Required);
                    $("input[name='away_score']").addClass("error-input-val");
                    !error && $("input[name='away_score']").focus();
                    error = true;
                } else if (away_score.trim() === "") {
                    event.preventDefault();
                    $("input[name='away_score']").val(result_Required);
                    $("input[name='away_score']").addClass("error-input-val");
                    !error && $("input[name='away_score']").focus();
                    error = true;
                }
            });

        
            let clickedOnce = false;
            $('#predictionClose-action').on('click', function (e) {
                const $btn = $(this);
                const originalText = "{{ __('predictionClose.close_button') }}";
                const confirmText = "{{ __('predictionClose.confirm_close_button') }}";

                if (!clickedOnce) {
                    e.preventDefault(); 
                    clickedOnce = true;
                    $btn
                        .val(confirmText)
                        .addClass('btn-danger vibrate')
                        .removeClass('btn-primary');


                        setTimeout(() => {
                        $btn.removeClass('vibrate');
                    }, 600);
                    
                    // Submit the form after a delay
                    setTimeout(() => {
                        clickedOnce = false;
                        $btn
                            .val(originalText)
                            .removeClass('btn-danger')
                            .addClass('btn-primary');
                    }, 5000);
                }
            });
        });
    </script>

    <div class="row bg-gradient-secondary justify-content-center align-items-center py-4">
        <div class="col-8 col-sm-6 col-md-5 col-lg-4 col-xl-3">

            <ul class="nav nav-tabs" id="addTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link nav-link_auth active border-0" id="football-tab" data-bs-toggle="tab" 
                    data-bs-target="#football" type="button" role="tab">
                        {{ __('predictionClose.football_tab') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="authTabContent">
                <div class="tab-pane fade show active" id="football" role="tabpanel">

                    <form action="{{ route('predictionClose.update', ['predictionClose'=>$eventFootball->id]) }}" method="POST" id="football-form">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="type" value="football">  
                        
                        <div class="mb-3">
                            <input type="text" name="competition" class="form-control custom-input-form" value="{{$eventFootball->competition}}" disabled />
                        </div>
                        
                        <div class="mb-3">
                            <input type="text" name="start_time" class="form-control custom-input-form" value="{{ \Carbon\Carbon::parse($eventFootball->start_time)->translatedFormat('d-m-Y, H:i') }}" disabled />
                        </div>
                        <div class="row">
                            <div class="col-9 mb-3">
                                <input type="text" name="home_team" id="home_team" class="form-control custom-input-form" value="{{$eventFootball->home_team}}" disabled />
                            </div>
                            <div class="col-3 mb-3">
                                <input type="number" name="home_score" id="home_score" class="form-control custom-input-form" value="{{$eventFootball->home_score}}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-9 mb-3">
                                <input type="text" name="away_team" id="away_team" class="form-control custom-input-form" value="{{$eventFootball->away_team}}" disabled />
                            </div>
                            <div class="col-3 mb-3">
                                <input type="number" name="away_score" id="away_score" class="form-control custom-input-form" value="{{$eventFootball->away_score}}" />
                            </div>
                        </div>

                        
                        <div class="d-grid py-3">
                            <input type="submit" class="btn btn-success" id="predictionClose-action" value="{{ __('predictionClose.close_button') }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection