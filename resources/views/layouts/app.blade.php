<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smartfarm') }}</title>

    <!-- Styles -->
    @include('layouts.partials.styles')
</head>

<body>
    <div id="app">
        {{-- Modal --}}
        <div class="modal fade text-left" id="default" tabindex="-1" aria-labelledby="myModalLabel1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body" id="modalBody">

                    </div>
                    <div class="modal-footer" id="modalFooter">

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.partials.sidebar')

        <div id="main" class='layout-navbar'>
            @include('layouts.partials.header')
            <div id="main-content">

                <div class="page-heading">
                    <div class="page-title">
                        {{ $header }}
                    </div>
                    {{ $slot }}
                </div>

                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @include('layouts.partials.scripts')

</body>

</html>
