@extends('layouts.primary')

@section('head', __('prediction.page_title'))

@section('prediction-active', 'active')

@section('body-hero')
  @if(session('success'))
      <script>
          toastr.success("{{ session('success') }}");
      </script>
  @endif

  @if(session('error'))
      <script>
          toastr.error("{{ session('error') }}");
      </script>
  @endif

  <script>
      $(document).ready(function () {
          $('.reset-btn').click(function (event) {
              event.preventDefault();
              var footballId = $(this).data('target');
              $('input[name="' + footballId + '"]').prop('checked', false);
          });
      });
  </script>


    
  <h1 class="display-4 fw-bold">{{ __('prediction.heading') }}</h1>
  <p class="lead mt-3 mx-3">{{ __('prediction.subheading') }}</p>
  <div class="date-display align-items-center justify-content-center mt-2">
    <i class="fas fa-calendar-day me-2"></i>
    <span>{{ \Carbon\Carbon::now()->translatedFormat('d M') }}</span>
  </div>
@endsection


@section('body-features')
<form class="justify-content-center" action="{{ Auth::check() ? route('prediction.store') : route('login.create') }}" 
      method="{{ Auth::check() ? 'POST' : 'GET' }}">
    @csrf
    <div class="row g-5 justify-content-center">

      @php 
        $totalPredictions = 0;
      @endphp
      @foreach ($eventsFootball as $eventFootball)
      <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-light-secondary border-0 shadow-sm">
          <div class="card-body text-center px-4">
            <h5 class="card-title fs-4 fw-semibold">{{$eventFootball->home_team}} - {{$eventFootball->away_team}}</h5>
            <p class="text-muted mb-3">{{$eventFootball->competition}} {{ __('prediction.match_time_separator') }} 
              <span class="small text-secondary">{{ \Carbon\Carbon::parse($eventFootball->start_time)->translatedFormat('H:i') }}</span> 
            {{ __('prediction.match_location_separator') }} {{$eventFootball->stadium}}</p>

            @php
              $footballId = $eventFootball->id;
              $result = 'null';
              $prediction = 'null';

              if (!is_null($eventFootball->home_score) && !is_null($eventFootball->away_score)) {
                if ($eventFootball->home_score > $eventFootball->away_score) {
                  $result = '1';
                } elseif ($eventFootball->home_score < $eventFootball->away_score) {
                  $result = '2';
                } else {
                  $result = 'X';
                }
              }

              if ($eventFootball->predicted_1) {
                $prediction = '1';
              } elseif ($eventFootball->predicted_2) {
                $prediction = '2';
              } elseif ($eventFootball->predicted_X) {
                $prediction = 'X';
              }

              $testStatus = '';
              $btnStatus = '';
              $btnPrediction = 'btn-fix-predict';

              switch ($eventFootball->status) {
                case __('prediction.status_scheduled'):
                  $testStatus = 'text-status-scheduled';
                  $btnStatus = 'btn-fix-scheduled';
                  break;

                case __('prediction.status_ended'):
                  $testStatus = 'text-status-ended';
                  $btnStatus = 'btn-fix-ended';
                  break;

                case __('prediction.status_deleted'):
                  $testStatus = 'text-status-deleted';
                  $btnStatus = 'btn-fix-deleted';
                  break;

                case __('prediction.status_in_progress'):
                  $testStatus = 'text-status-progress';
                  $btnStatus = 'btn-fix-progress';
                  break;
              }
            @endphp

            <div class="btn-group" role="group" data-football-id="{{ $footballId }}">
              @if( (!Auth::check()) || ($eventFootball->status != __('prediction.status_scheduled')))
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-1" value="{{ __('prediction.button_home_win') }}" disabled>
                <label class="btn btn-outline-primary {{$result=='1' ? $btnStatus : ''}} 
                {{$prediction=='1' ? $btnPrediction : ''}}" for="{{$footballId}}-1">{{ __('prediction.button_home_win') }}</label>
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-X" value="{{ __('prediction.button_draw') }}" disabled>
                <label class="btn btn-outline-primary {{$result=='X' ? $btnStatus : ''}} 
                {{$prediction=='X' ? $btnPrediction : ''}}" for="{{$footballId}}-X">{{ __('prediction.button_draw') }}</label>
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-2" value="{{ __('prediction.button_away_win') }}" disabled>
                <label class="btn btn-outline-primary {{$result=='2' ? $btnStatus: ''}} 
                {{$prediction=='2' ? $btnPrediction : ''}}" for="{{$footballId}}-2">{{ __('prediction.button_away_win') }}</label>
              @else
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-1" value="{{ __('prediction.button_home_win') }}">
                <label class="btn btn-outline-primary {{$prediction=='1' ? $btnPrediction : ''}}" for="{{$footballId}}-1">{{ __('prediction.button_home_win') }}</label>
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-X" value="{{ __('prediction.button_draw') }}">
                <label class="btn btn-outline-primary {{$prediction=='X' ? $btnPrediction : ''}}" for="{{$footballId}}-X">{{ __('prediction.button_draw') }}</label>
                <input type="radio" class="btn-check" name="{{$footballId}}" id="{{$footballId}}-2" value="{{ __('prediction.button_away_win') }}">
                <label class="btn btn-outline-primary {{$prediction=='2' ? $btnPrediction: ''}}" for="{{$footballId}}-2">{{ __('prediction.button_away_win') }}</label>
                @if ($prediction == 'null')
                  @php $totalPredictions++; @endphp
                  <button type="reset" class="btn btn-outline-secondary btn-sm ms-2 reset-btn" data-target="{{ $footballId }}">
                    <i class="fas fa-undo"></i>
                  </button>
                @endif
              @endif
            </div>
            <p class="pt-2 mb-0 {{$testStatus}}">{{$eventFootball->status}}</p>
          </div>
        </div>
      </div>
      @endforeach

      <div class="col-12 text-center mt-4"">
        @php 
          $disabled = '';
          if(isset($error) && Auth::check()) 
            $disabled='disabled';
        @endphp
        <button type="submit" class="btn btn-primary btn-lg px-4 mt-3" {{ $disabled }}>
          @if(Auth::check())
            {{ __('prediction.submit_logged_in') }}
          @else
            {{ __('prediction.submit_guest') }}
          @endif
        </button>
        @if (Auth::check() && !isset($error) && $totalPredictions > 1)
          <button type="reset" class="btn btn-outline-secondary ms-2 btn-lg px-2 mt-3 ">
            <i class="fas fa-undo"></i>
          </button>
        @endif
      </div>
    </div>
  </form>
@endsection