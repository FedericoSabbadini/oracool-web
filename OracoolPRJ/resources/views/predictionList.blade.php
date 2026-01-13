@extends('layouts.master')

@section('back')
    <a href="{{ route('controlPanel.index') }}" class="text-white text-decoration-none d-inline-flex align-items-center gap-1 small back-link">
        <i class="bi bi-arrow-left"></i>
    </a>
@endsection

@section('head', __('predictionList.page_title'))

@if ($action === 'edit')
    @section('predictionEdit-active', 'active')
@else
    @section('predictionClose-active', 'active')
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
            pageLength: 8,
            pagingType: "simple",       // Usa la paginazione semplice (precedente/successivo)
            columnDefs: [{
            orderable: false,
            targets: [3, 1]                // Disabilita ordinamento su colonne 1 e 3   
            }],
            order: [[0, 'asc']],          // Ordina per la prima colonna (orario) in ordine ascendente
        });
    </script>

    <div class="row bg-gradient-secondary justify-content-center pt-2 pb-3 px-4">
        <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8">
            <div class="table-responsive mt-5">
                <table class="table table-striped table-bordered text-center table-hover align-middle" id="dataTable">
                    <thead class="table-dark ">
                        <tr>
                            <th class="col-2" scope="col">{{ __('predictionList.orario') }}</th>
                            <th class="pers-th col-6" scope="col">{{ __('predictionList.match') }}</th>
                            <th class="d-none d-md-table-cell col-2" scope="col">{{ __('predictionList.status') }}</th>
                            <th class="pers-th col-2" scope="col">{{ __('predictionList.action') }}</th>
                        </tr>
                    </thead>                            

                    <tbody>
                        @foreach ($eventsFootball as $eventFootball)
                            @php
                                $date = \Carbon\Carbon::parse($eventFootball->start_time)->translatedFormat('d-m-y H:i');
                                $dataOrder = \Carbon\Carbon::parse($eventFootball->start_time)->format('Y-m-d H:i');
                                $homeTeam = $eventFootball->home_team;
                                $awayTeam = $eventFootball->away_team;
                                $status = $eventFootball->status;

                                $href = $action === 'edit' ? 
                                    route('predictionEdit.show', ['predictionEdit' => $eventFootball->id]) : 
                                    route('predictionClose.show', ['predictionClose' => $eventFootball->id]);

                                $buttonClass = $action === 'edit' ? 'btn-warning' : 'btn-success'; // Arancio per edit, verde per close
                                $buttonText = __('predictionList.' . $action); // Modifica o Chiudi
                            @endphp
                            <tr class="table-row">
                                <td class=" text-secondary small" data-order="{{ $dataOrder }}">{{ $date }}</td>
                                <td>{{ $homeTeam }} <span class="text-secondary small">vs</span> {{ $awayTeam }}</td>
                                <td class="d-none d-md-table-cell">{{ $status }}</td>
                                <td>
                                    <a href="{{ $href }}" class="btn {{ $buttonClass }} btn-sm">{{ $buttonText }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($action === 'edit')
                <div class="row align-items-end mt-2 mb-4">
                    <div class="col-12 d-flex justify-content-end">
                        <form action="{{ route('admin.matches.update') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt"></i>  Matches
                            </button>
                        </form>
                        <form action="{{ route('admin.odds.update') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning  ms-2">
                                <i class="fas fa-sync-alt"></i> {{ __('predictionList.quotes') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>       
    </div>            
@endsection