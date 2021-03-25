<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

{{-- HEAD --}}
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>
  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  @stack('css')

</head>

{{-- BODY --}}
<body class="styled-scrollbar">

  @yield('body')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    dayjs.locale('{{ App::getLocale() }}')
    console.log('locale', dayjs.locale());
  </script>
  {{-- <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-custom="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new window.bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script> --}}

  @stack('script')

</body>

</html>