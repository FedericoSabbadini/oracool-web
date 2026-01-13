<!DOCTYPE html>

<html lang="it">

    <head>
        <title>
            @yield('head')
        </title>

        <!-- Caricamento dei meta tag -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Caricamento CSS per Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
       
        <!-- CSS personalizzato -->
        <link href="{{ url('/') }}/css/style.css" rel="stylesheet">
        <link href="{{ url('/') }}/css/dataTables.css" rel="stylesheet">

        <!-- Font Awesome per le icone -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- Caricamento jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Uso della versione senza "slim" -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- Caricamento Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <!-- Caricamento myScript -->
        <script src="{{ url('/') }}/js/timezone.js"></script> <!-- Uso della versione senza "slim" -->
        
        <!-- Caricamento DataTables CSS e JS -->
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('/') }}/js/datatable_config.js"></script>
        
        <!-- Toastr CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ url('/') }}/js/toastr_config.js"></script>

    </head>

    <body>

        <script>
            $(document).ready(function () {

                // Imposta il fuso orario del browser
                setTimezone();

                // Gestione del click sul link per cambiare il ruolo di amministratore
                $('#isAdmin-action').on('click', function(e) {
                    e.preventDefault();
                    let adminValue = $('#isAdmin-form input[name="isAdmin"]').val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("set.isAdmin") }}',
                        type: 'POST',
                        data: {
                            admin: adminValue
                        },
                        success: function() {
                            $('#isAdmin-form').submit();
                        },

                    });
                });


                let clickedOnce = false;
                // Gestione del click sul link di logout
                $('#logout-action').on('click', function (e) {
                    e.preventDefault();
                    
                    if (!clickedOnce) {
                        clickedOnce = true;

                        $(this).text("{{ __('master.confirm_log_out') }}");
                        $(this).css({'color': '#ff0000', 'font-weight': '600'}); 
                        $('#isAdmin-li').show();

                        // Imposta un timeout per ripristinare il testo e lo stile dopo 5 secondi
                        setTimeout(function() {
                            clickedOnce = false;
                            $('#logout-action').css({'color': '', 'font-weight': ''}); 
                            $('#logout-action').text("{{ __('master.log_out') }}");
                            $('#isAdmin-li').hide();
                        }, 5000);
                    } else {
                          $('#logout-form').submit();
                    }
                    
                });
            });
        </script>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container px-4">
                
                <div class="navbar-brand">
                    @if (Auth::check() && Auth::user()->admin)
                       <strong>Oracool</strong> <small  class="fs-6">admin</small>
                    @else
                        <strong>Oracool</strong> 
                    @endif
                    @yield('back')
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        
                        @php
                            $lang = session('language');
                            $langUpdate = $lang == 'it' ? 'en' : 'it';
                        @endphp 

                        @if(Auth::check())
                            @if(Auth::user()->admin)
                                <li class="nav-item"><a class="nav-link @yield('controlPanel-active')" href="{{ route('controlPanel.index') }}">{{ __('master.home') }}</a></li>
                                <li class="nav-item"><a class="nav-link disabled @yield('predictionAdd-active')">{{ __('master.add') }}</a></li>
                                <li class="nav-item"><a class="nav-link disabled @yield('predictionEdit-active')" >{{ __('master.edit') }}</a></li>
                                <li class="nav-item  pe-4"><a class="nav-link disabled @yield('predictionClose-active')" >{{ __('master.close') }}</a></li>

                                <li class="nav-item" style="display:none;" id="isAdmin-li"><a id="isAdmin-action" class="nav-link text-warning" href="#">{{ __('master.change_logU') }}</a>
                                    <form id="isAdmin-form" action="{{ route('userProfile.index') }}" method="GET" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="isAdmin" value="0">
                                    </form>
                                </li>
                                <li class="nav-item"><a id="logout-action" class="nav-link text-danger" href="#">{{ __('master.log_out') }}</a>
                                    <form id="logout-form" action="{{ route('logout.destroy') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('lang.edit', ['lang' => $langUpdate]) }}">{{ strtoupper($langUpdate)  }}</a></li>

                            @else
                                <li class="nav-item"><a class="nav-link @yield('home-active')" href="{{ route('home.index') }}">{{ __('master.home') }}</a></li>
                                <li class="nav-item"><a class="nav-link @yield('prediction-active')" href="{{ route('prediction.create') }}">{{ __('master.predictions') }}</a></li>
                                <li class="nav-item"><a class="nav-link @yield('ranking-active')" href="{{ route('ranking.index') }}">{{ __('master.ranking') }}</a></li>
                                <li class="nav-item pe-4"><a class="nav-link @yield('userProfile-active')" href="{{ route('userProfile.index') }}">{{ __('master.profile') }}</a></li>
                                
                                @if (Auth::user()->adminKey != null)
                                    <li class="nav-item" style="display:none;" id="isAdmin-li"><a id="isAdmin-action" class="nav-link text-warning" href="#">{{ __('master.change_logA') }}</a>
                                        <form id="isAdmin-form" action="{{ route('home.index') }}" method="GET" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="isAdmin" value="1">
                                        </form>
                                    </li>
                                @endif

                                <li class="nav-item"><a id="logout-action" class="nav-link text-danger" href="#">{{ __('master.log_out') }}</a>
                                    <form id="logout-form" action="{{ route('logout.destroy') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                
                                <li class="nav-item"><a class="nav-link" href="{{ route('lang.edit', ['lang' => $langUpdate]) }}">{{ strtoupper($langUpdate)  }}</a></li>

                            @endif
                        @else
                            <li class="nav-item"><a class="nav-link @yield('home-active')" href="{{ route('home.index') }}">{{ __('master.home') }}</a></li>
                            <li class="nav-item"><a class="nav-link @yield('prediction-active')" href="{{ route('prediction.create') }}">{{ __('master.predictions') }}</a></li>
                            <li class="nav-item  pe-4"><a class="nav-link @yield('ranking-active')" href="{{ route('ranking.index') }}">{{ __('master.ranking') }}</a></li>
                            <li class="nav-item" ><a class="nav-link text-primary @yield('login-active')" href="{{ route('login.create') }}">{{ __('master.log_in') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('lang.edit', ['lang' => $langUpdate]) }}">{{ strtoupper($langUpdate) }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        

        
        <div class="separator"></div>
        <div class="container-fluid px-0">
            @yield('body')
        </div>


        <footer class=" text-white">
            <div class="container px-4 text-center">
                <small class="footer">© 2025 
                    <strong>Oracool</strong> - {{ __('master.all_rights_reserved') }}
                </small>
            </div>
        </footer>

    </body>

    @yield('scripts')
</html>