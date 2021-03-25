@push('css')
  <style>
    html,
    body {
      overflow-x: hidden; /* Prevent scroll on narrow devices */
    }

    body {
      padding-top: 56px;
    }

    @media (max-width: 991.98px) {
      .offcanvas-collapse {
        position: fixed;
        top: 56px;
        /* Height of navbar */
        bottom: 0;
        left: 100%;
        width: 100%;
        padding-right: 1rem;
        padding-left: 1rem;
        overflow-y: auto;
        visibility: hidden;
        background-color: var(--bs-primary);
        transition: transform .3s ease-in-out, visibility .3s ease-in-out;
      }
      .offcanvas-collapse.open {
        visibility: visible;
        transform: translateX(-100%);
      }
    }
  </style>
@endpush

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary" aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('welcome') }}">
      <img src="{{ asset('images/logo.png') }}" height="30" alt="" loading="lazy" />
    </a>
    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse offcanvas-collapse" id="offcanvas-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item ">
          <a
            class="nav-link @if(Request::is('/')) active @endif"
            href="{{ route('welcome') }}"
            @if(Request::is('/')) aria-current="page" @endif
            role="button"
          >
            @lang('action.home')
          </a>
        </li>

        <li class="nav-item ">
          <a
            class="nav-link @if(Request::is('submission')) active @endif"
            href="{{ route('submission') }}"
            @if(Request::is('submission')) aria-current="page" @endif
            role="button"
          >
            @lang('action.submissions')
          </a>
        </li>

      </ul>
      <ul class="navbar-nav d-flex flex-row">

        @php
          $links = Helper::getStaticJson()['links'];
          $socialMedia = $links['social-media'];
          $googleMaps = $links['google-maps'];
        @endphp

        {{-- https://goo.gl/maps/hZUypB12fq7wf2mT9 --}}
        @if($googleMaps['use'])
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link styled-hover-sm-swing-ver" href="{{ url($googleMaps['link']) }}" rel="nofollow" target="_blank">
              <i class="fas fa-map-marker-alt"></i>
            </a>
          </li>
        @endif

        {{-- https://www.facebook.com/beacukaijember --}}
        @if($socialMedia['facebook']['use'])
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link styled-hover-sm-swing-ver" href="{{ url($socialMedia['facebook']['link']) }}" rel="nofollow" target="_blank">
              <i class="fab fa-facebook-f fa-fw"></i>
            </a>
          </li>
        @endif

        {{-- https://twitter.com/beacukaijember --}}
        @if($socialMedia['twitter']['use'])
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link styled-hover-sm-swing-ver" href="{{ url($socialMedia['twitter']['link']) }}" rel="nofollow" target="_blank">
              <i class="fab fa-twitter fa-fw"></i>
            </a>
          </li>
        @endif

        {{-- https://www.instagram.com/beacukaijember --}}
        @if($socialMedia['instagram']['use'])
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link styled-hover-sm-swing-ver" href="{{ url($socialMedia['instagram']['link']) }}" rel="nofollow" target="_blank">
              <i class="fab fa-instagram fa-fw"></i>
            </a>
          </li>
        @endif
        
        {{-- https://www.youtube.com/channel/UCUn2oP2kr2BhxjzMWPdiRlw --}}
        @if($socialMedia['youtube']['use'])
          <li class="nav-item me-3 me-lg-0">
            <a class="nav-link styled-hover-sm-swing-ver" href="{{ url($socialMedia['youtube']['link']) }}" rel="nofollow" target="_blank">
              <i class="fab fa-youtube fa-fw"></i>
            </a>
          </li>
        @endif

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLocale" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ App::getLocale() }}
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end" style="min-width: 3rem;" aria-labelledby="navbarDropdownLocale">
            @foreach (config('global.locales') as $locale)
              @if($locale != App::getLocale())
                <li>
                  <a class="dropdown-item" href="{{ route('localize', ['locale' => $locale]) }}">
                    {{ $locale }}
                  </a>
                </li>
              @endif
            @endforeach
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

@push('script')
  <script>
    $(document).ready(function() {
      'use strict'
      $('[data-bs-toggle="offcanvas"]').click(function(e) { $('#offcanvas-collapse').toggleClass('open');});
    });
  </script>
@endpush