@extends('layouts.master')

@section('body')
        <section class="bg-primary text-white text-center py-5">
                @yield('body-hero')
        </section>

        <section class="bg-light py-5 px-5">
                @yield('body-features')
        </section>
@endsection