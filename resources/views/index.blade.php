@extends('layouts.primary')

@section('head', 'Oracool')

@section('home-active', 'active')

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
    
    <h1 class="display-4 fw-bold">{{ __('index.welcome') }} 
        <strong>{{ __('index.brand') }}</strong>
    </h1>
    <p class="lead mt-3">{{ __('index.tagline') }}</p>
    @if(Auth::check())
        <a href="{{ route('prediction.create') }}" class="btn btn-light btn-lg mt-3">{{ __('index.cta_logged_in') }}</a>
    @else
        <a href="{{ route('login.create') }}" class="btn btn-light btn-lg mt-3">{{ __('index.cta_guest') }}</a>
    @endif
@endsection


@section('body-features')
    <div class="container">
        <div class="row g-5 justify-content-center">

            <div class="col-6 col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 text-center feature-card">
                    <div class="mb-3">
                        <span class="fs-1">
                            <i class="fas fa-chart-bar fs-1 predict-icon"></i>
                        </span>
                    </div>

                    <h4 class="fw-semibold mb-3">{{ __('index.feature_predict_title') }}</h4>
                    <p class="text-muted">{{ __('index.feature_predict_text') }}</p>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 text-center feature-card">
                    <div class="mb-3">
                        <span class="fs-1">
                            <i class="fas fa-handshake handshake-icon"></i>
                        </span>
                    </div>

                    <h4 class="fw-semibold mb-3">{{ __('index.feature_community_title') }}</h4>
                    <p class="text-muted">{{ __('index.feature_community_text') }}</p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 text-center feature-card">
                    <div class="mb-3">
                        <span class="fs-1">
                            <i class="fas fa-user fs-1 personal-icon"></i>
                        </span>
                    </div>
                        
                    <h4 class="fw-semibold mb-3">{{ __('index.feature_growth_title') }}</h4>
                    <p class="text-muted">{{ __('index.feature_growth_text') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection