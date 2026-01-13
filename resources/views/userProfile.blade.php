@extends('layouts.master')

@if ($user->id == Auth::user()->id) 
        @section('userProfile-active', 'active')
        @section('head', __('userProfile.page_title_own'))
    
@endif

@if ($user->id != Auth::user()->id) 
    @section('ranking-active', 'active')
    @section('head', __('userProfile.page_title_other'))
    @section('back')
        <a href="{{ url()->previous() }}" class="text-white text-decoration-none d-inline-flex align-items-center gap-1 small back-link">
            <i class="bi bi-arrow-left"></i>
        </a>
    @endsection
@endif


@section('body')

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
        initializeDataTable('dataTable', {
            pageLength: 9,
            pagingType: "simple",   // Usa la paginazione semplice (precedente/successivo)
            columnDefs: [{
            orderable: false,
            targets: [1, 3]         // Disabilita ordinamento su colonne 1 e 3   
            }],
            order: [[0, 'desc']],
            dom: '<"row"<"col-12"tr>>' + 
                    '<"row"<"col-12 custom-pagination"p>>',
        });
    </script>

    <div class="row bg-gradient-secondary justify-content-center py-4">
        <div class="col-9 col-sm-9 col-md-7 col-lg-5 col-xl-4">
                <div class="card text-center shadow mx-4 mt-5 mb-4 card-profile">
                    <section class="card-body">
                        <h4 class="card-title">
                            <a class="no-link" href="{{ route('ranking.index') }}" >{{ '@' . $user->name }}</a>
                        </h4>
                        <p class="text-muted">{{ __('userProfile.member_since') }} {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('M Y')}}</p>
                        <hr />

                        @php
                            $totPredictions = $userPredictions->where('value', '!=', null)->count();
                            $correctPredictions = $userPredictions->where('value', 1)->count();
                            $accuracy = $totPredictions > 0 ? round(($correctPredictions / $totPredictions) * 100, 2) : 0;
                            $lastAccess = \Carbon\Carbon::parse($user->last_access)->translatedFormat('d-m-y H:i');
                        @endphp

                        <p><strong>{{ __('userProfile.points') }}</strong> <span class="text-muted">{{number_format($user->points, 2, '.', '')}}</span></p>
                        <p><strong>{{ __('userProfile.total_predictions') }}</strong> {{ $totPredictions}}</p>
                        <p><strong>{{ __('userProfile.correct_predictions') }}</strong> {{$correctPredictions}}</p>
                        <p><strong>{{ __('userProfile.accuracy') }}</strong> <span class="{{ $accuracy > 75 ? 'text-success' : ($accuracy > 50 ? 'text-warning' : 'text-danger') }}">{{$accuracy . '%'}}</span></p>
                        <p><strong>{{ __('userProfile.lastAccess') }}</strong> <span class="text-secondary small">{{ $lastAccess }}</span></p>
                    </section>
                </div>
        </div>

        <div class="col-12 col-sm-11 col-md-11 col-lg-6 col-xl-7 px-4">
            <div class="table-responsive mt-5 mb-4">
                <table class="table table-striped text-center align-middle table-hover table-bordered" id="dataTable">
                    <thead class="table-dark ">
                    <tr>
                        <th class="col-2">{{ __('userProfile.history_date') }}</th>
                        <th class="pers-th col-6">{{ __('userProfile.history_match') }}</th>
                        <th class="d-none d-md-table-cell col-2" scope="col">{{ __('userProfile.history_prediction') }}</th>
                        <th class="pers-th col-2">{{ __('userProfile.history_result') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($userPredictions as $prediction)
                            @php
                                $event=$userEvents->where('id', $prediction->event_id)->first();
                                $date= \Carbon\Carbon::parse($event->start_time)->translatedFormat('d-m-y');
                                $dataOrder = \Carbon\Carbon::parse($event->start_time)->format('m-d-Y');


                                if ($event->type == 'football') {
                                    $predictionFootball=$userPredictionsFootball->where('id', $prediction->id)->first();
                                    $eventFootball=$userEventsFootball->where('id', $prediction->event_id)->first();
                                    $homeTeam = $eventFootball->home_team;
                                    $awayTeam = $eventFootball->away_team;

                                    if($predictionFootball->predicted_1) {
                                        $result = '1';
                                    } elseif($predictionFootball->predicted_X) {
                                        $result = 'X';
                                    } elseif($predictionFootball->predicted_2) {
                                        $result = '2';
                                    } else {
                                        $result = 'null';
                                    }

                                    $goalA= $eventFootball->home_score;
                                    $goalB= $eventFootball->away_score;
                                }
                            @endphp
                            <tr>
                                <td class=" text-secondary small" data-order="{{ $dataOrder }}">{{ $date }}</td>
                                <td>{{ $homeTeam }} <span class="text-secondary small">vs</span> {{ $awayTeam }}</td>
                                <td class="d-none d-md-table-cell"><strong>{{ $result }}</strong></td>
                                <td><span class="badge {{ $prediction->value=='1' ? 'bg-success' 
                                : ($prediction->value == '0' ? 'bg-danger' : 'bg-warning') }}">{{ $goalA . '-' . $goalB }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>        
    </div>
@endsection