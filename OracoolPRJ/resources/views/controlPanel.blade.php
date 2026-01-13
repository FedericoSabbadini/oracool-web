@extends('layouts.primary')

@section('head', __('controlPanel.page_title'))

@section('controlPanel-active', 'active')

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

  <h1 class="display-4 fw-bold">{{ __('controlPanel.header') }}</h1>
  <p class="lead mt-3 px-4">{{ __('controlPanel.subheader') }}</p>
  <div class="date-display align-items-center justify-content-center mt-2">
    <i class="fas fa-calendar-day me-2"></i>
    <span>{{ \Carbon\Carbon::now()->translatedFormat('d M') }}</span>
  </div>
@endsection

@section('body-features')
  <div class="row g-5 justify-content-center d-flex">
    <div class="col-8 col-sm-7 col-md-5 col-lg-4 col-xl-3">
      <div class="card bg-light-secondary border-0 shadow-sm">
        <div class="card-body text-center py-4">
          <h4 class="fw-semibold mb-3">{{ __('controlPanel.add_title') }}</h4>
          <p class="text-muted mb-3">{{ __('controlPanel.add_description') }}</p>
          <a class="btn btn-primary btn-sm px-3 py-2" href="{{route('predictionAdd.create')}}">
            <i class="bi bi-plus-circle"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="col-8 col-sm-7 col-md-5 col-lg-4 col-xl-3">
      <div class="card bg-light-secondary border-0 shadow-sm">
        <div class="card-body text-center py-4">
          <h4 class="fw-semibold mb-3">{{ __('controlPanel.edit_title') }}</h4>
          <p class="text-muted mb-3">{{ __('controlPanel.edit_description') }}</p>
          <a class="btn btn-warning btn-sm px-3 py-2" href="{{route('predictionEdit.create')}}">
            <i class="bi bi-pencil-square"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="col-8 col-sm-7 col-md-5 col-lg-4 col-xl-3">
      <div class="card bg-light-secondary border-0 shadow-sm">
        <div class="card-body text-center py-4">
          <h4 class="fw-semibold mb-3">{{ __('controlPanel.close_title') }}</h4>
          <p class="text-muted mb-3">{{ __('controlPanel.close_description') }}</p>
          <a class="btn btn-success btn-sm px-3 py-2" href="{{route('predictionClose.create')}}">
            <i class="bi bi-calculator"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

@endsection