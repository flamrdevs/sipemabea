@php
  $bs_primary = '#02275d';
  $bs_secondary = '#ffcb05';
  $bs_success = '#38c172';
  $bs_info = '#6cb2eb';
  $bs_warning = '#ffed4a';
  $bs_danger = '#e3342f';
  $bs_light = '#f9f9fb';
  $bs_dark = '#3f4c61';
  $bs_white = '#ffffff';
  $bs_black = '#000000';
@endphp

<head>
  <style>
    .bs.body{
      margin: 0;
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.6;
      color: {{ $bs_dark }};
      background-color: {{ $bs_white }};
    }
  
    .bs *, .bs *::after, .bs *::before{padding: 0;margin: 0;box-sizing: border-box;}

    .bs.d-flex{display: flex !important;}

    .bs.justify-content-center{justify-content: center !important;}

    .bs.flex-grow-1{flex-grow: 1 !important;}

    .bs.p-0{padding:0 !important}
    .bs.p-1{padding:.25rem !important}
    .bs.p-2{padding:.5rem !important}
    .bs.p-3{padding:1rem !important}
    .bs.p-4{padding:1.5rem !important}
    .bs.p-5{padding:3rem !important}

    .bs.px-0{padding-right:0 !important; padding-left:0 !important}
    .bs.px-1{padding-right:.25rem !important; padding-left:.25rem !important}
    .bs.px-2{padding-right:.5rem !important; padding-left:.5rem !important}
    .bs.px-3{padding-right:1rem !important; padding-left:1rem !important}
    .bs.px-4{padding-right:1.5rem !important; padding-left:1.5rem !important}
    .bs.px-5{padding-right:3rem !important; padding-left:3rem !important}

    .bs.py-0{padding-top:0 !important; padding-bottom:0 !important}
    .bs.py-1{padding-top:.25rem !important; padding-bottom:.25rem !important}
    .bs.py-2{padding-top:.5rem !important; padding-bottom:.5rem !important}
    .bs.py-3{padding-top:1rem !important; padding-bottom:1rem !important}
    .bs.py-4{padding-top:1.5rem !important; padding-bottom:1.5rem !important}
    .bs.py-5{padding-top:3rem !important; padding-bottom:3rem !important}

    .bs.m-0{margin:0 !important}
    .bs.m-1{margin:.25rem !important}
    .bs.m-2{margin:.5rem !important}
    .bs.m-3{margin:1rem !important}
    .bs.m-4{margin:1.5rem !important}
    .bs.m-5{margin:3rem !important}

    .bs.mx-0{margin-right:0 !important; margin-left:0 !important}
    .bs.mx-1{margin-right:.25rem !important; margin-left:.25rem !important}
    .bs.mx-2{margin-right:.5rem !important; margin-left:.5rem !important}
    .bs.mx-3{margin-right:1rem !important; margin-left:1rem !important}
    .bs.mx-4{margin-right:1.5rem !important; margin-left:1.5rem !important}
    .bs.mx-5{margin-right:3rem !important; margin-left:3rem !important}

    .bs.my-0{margin-top:0 !important; margin-bottom:0 !important}
    .bs.my-1{margin-top:.25rem !important; margin-bottom:.25rem !important}
    .bs.my-2{margin-top:.5rem !important; margin-bottom:.5rem !important}
    .bs.my-3{margin-top:1rem !important; margin-bottom:1rem !important}
    .bs.my-4{margin-top:1.5rem !important; margin-bottom:1.5rem !important}
    .bs.my-5{margin-top:3rem !important; margin-bottom:3rem !important}

    .bs.rounded{border-radius:.45rem !important}
    .bs.rounded-0{border-radius:0 !important}
    .bs.rounded-1{border-radius:.3rem !important}
    .bs.rounded-2{border-radius:.45rem !important}
    .bs.rounded-3{border-radius:.6rem !important}
    .bs.rounded-circle{border-radius:50% !important}
    .bs.rounded-pill{border-radius:50rem !important}

    .bs.shadow{box-shadow:0 .5rem 1rem rgba(0,0,0,.15) !important}
    .bs.shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075) !important}
    .bs.shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175) !important}
    
    /* a */
    a.bs{color: {{ $bs_primary }} !important;text-decoration: none !important;}

    /* background-color */
    .bs.bg-primary{background-color: {{ $bs_primary }} !important;}
    .bs.bg-secondary{background-color: {{ $bs_secondary }} !important;}
    .bs.bg-success{background-color: {{ $bs_success }} !important;}
    .bs.bg-info{background-color: {{ $bs_info }} !important;}
    .bs.bg-warning{background-color: {{ $bs_warning }} !important;}
    .bs.bg-danger{background-color: {{ $bs_danger }} !important;}
    .bs.bg-light{background-color: {{ $bs_light }} !important;}
    .bs.bg-dark{background-color: {{ $bs_dark }} !important;}
    .bs.bg-white{background-color: {{ $bs_white }} !important;}
    .bs.bg-black{background-color: {{ $bs_black }} !important;}

    /* color */
    .bs.text-primary{color: {{ $bs_primary }} !important;}
    .bs.text-secondary{color: {{ $bs_secondary }} !important;}
    .bs.text-success{color: {{ $bs_success }} !important;}
    .bs.text-info{color: {{ $bs_info }} !important;}
    .bs.text-warning{color: {{ $bs_warning }} !important;}
    .bs.text-danger{color: {{ $bs_danger }} !important;}
    .bs.text-light{color: {{ $bs_light }} !important;}
    .bs.text-dark{color: {{ $bs_dark }} !important;}
    .bs.text-white{color: {{ $bs_white }} !important;}
    .bs.text-black{color: {{ $bs_black }} !important;}
    
    .bs.badge-sm{padding: .25rem .5rem !important;}
    .bs.badge{padding: .5rem 1.5rem !important;}
    .bs.badge-lg{padding: 1.5rem 3rem !important;}

    .bs.hover:hover{background-color: {{ $bs_secondary }} !important;}
  </style>
</head>

<body class="bs body">

  @yield('body')

</body>