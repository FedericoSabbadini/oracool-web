@extends('layouts.master')

@section('head', __('ranking.page_title'))

@section('ranking-active', 'active')

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
            pageLength: 10,
        });
    </script>

    <div class="row bg-gradient-secondary justify-content-center pt-2 pb-3 px-4">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
            <div class="table-responsive my-5">
                <table class="table table-striped table-bordered text-center table-hover align-middle" id="dataTable">
                    <thead class="table-dark ">
                        <tr>
                            <th class="col-1" scope="col">{{ __('ranking.table_header_position') }}</th>
                            <th class="col-4" scope="col">{{ __('ranking.table_header_user') }}</th>
                            <th class="d-none d-md-table-cell col-1" scope="col">{{ __('ranking.table_header_points') }}</th>
                            <th class="d-none d-md-table-cell col-2" scope="col">{{ __('ranking.table_header_predictions') }}</th>
                            <th class="col-2" scope="col">{{ __('ranking.table_header_accuracy') }}</th>
                            <th class=" d-none d-lg-table-cell col-2" scope="col">{{ __('ranking.table_header_update') }}</th>

                        </tr>
                    </thead>                            
                    <tbody>
                        @php 
                            $num=0;
                            $points1=0;
                        @endphp
                        @foreach ($users as $user)
                            @php
                                $num=$num+1;
                                $totPredictions = $user->predictions->where('value', '!=', null)->count();
                                $correctPredictions = $user->predictions->where('value', 1)->count();
                                $accuracy = $totPredictions > 0 ? round(($correctPredictions / $totPredictions) * 100, 2) : 0;
                                $lastPrediction = $user->predictions->sortByDesc('created_at')->pluck('created_at')->first();

                                $colorUser = '';
                                $colorRanking = '';
                                if (Auth::check() && $user->id == Auth::user()->id)
                                    $colorUser = 'table-info';

                                if ($num == 1 || $user->points == $points1) {
                                    $colorRanking = 'text-warning'; 
                                    $points1 = $user->points;
                                } else {
                                    $colorRanking = ''; // No color for others
                                }

                            @endphp
                            <tr class="table-row {{$colorUser}}">
                                <th scope="row"><span>{{$num}}</span></th>
                                <td>
                                    @if(Auth::check())
                                        <a class="no-link {{$colorRanking}}" href="{{ route('userProfile.show', ['userProfile' => $user->id]) }}">{{ '@' . $user->name }}</a>
                                    @else
                                        <a class="no-link disabled-link {{$colorRanking}}" disabled;">{{ '@' . $user->name }}</a>
                                    @endif                               
                                </td>
                                <td class="d-none d-md-table-cell">{{ number_format($user->points, 2, '.', '') }}</td>
                                <td class="d-none d-md-table-cell">{{$totPredictions}}</td>
                                <td >{{$accuracy . '%'}}</td>
                                <td class="d-none  d-lg-table-cell text-secondary small">{{ \Carbon\Carbon::parse($lastPrediction)->translatedFormat('d-M-y') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>       
    </div>            
@endsection