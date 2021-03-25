@php
  use Carbon\Carbon;
  $adminPrefix = config('global.prefix-admin');
  $navlinkActiveClass = 'bg-primary text-light shadow-sm';
  $navlinkInactiveClass = 'text-dark styled-hover-bg-gray-200';
@endphp

@extends('layouts.app')

@push('css')
  <style>
    
    /*
    * Sidebar
    */

    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      padding: 48px 0 0;
    }

    @media (max-width: 767.98px) {
      .sidebar {
        top: 5rem;
      }
    }

    .sidebar-sticky {
      position: relative;
      top: 0;
      height: calc(100vh - 48px);
      padding-top: .5rem;
      overflow-x: hidden;
      overflow-y: auto;
    }

    /*
    * Navbar
    */

    .navbar-brand {
      padding-top: .75rem;
      padding-bottom: .75rem;
    }

    .navbar .navbar-toggler {
      top: .5rem;
      right: 1rem;
    }

    .nav-link.account-dropdown-toggler {
      transition: transform 0.2s ease, color 0.2s ease;
    }
    .nav-link.account-dropdown-toggler.active {
      transform: translateY(-3px);
    }

  </style>
@endpush

@section('body')
  <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">

    <div class="container-fluid">

      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ route('admin') }}">
        <img src="{{ asset('images/logo.png') }}" height="24" alt="" loading="lazy" />
        <span class="ms-2 text-light">{{ config('app.name') }}</span>
      </a>

      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="w-100">
        <span id="show-today-date" class="d-none d-md-block text-muted fs-6 styled-hover-color-gray-100 styled-cursor-default"></span>
      </div>

      <ul class="navbar-nav px-3 d-flex flex-row">
        <li id="locale-dropdown" class="nav-item dropdown me-3">
          <a class="nav-link dropdown-toggle account-dropdown-toggler" href="#" id="navbarDropdownLocale" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ App::getLocale() }}
          </a>
          <ul class="dropdown-menu md-position-absolute dropdown-menu-lg-end mb-3" style="min-width: 3rem;" aria-labelledby="navbarDropdownLocale">
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

        <li id="account-dropdown" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle account-dropdown-toggler" href="#" id="navbarDropdownUserAction" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user fa-fw me-1"></i>
            <span>{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu md-position-absolute dropdown-menu-lg-end mb-3" aria-labelledby="navbarDropdownUserAction">
            <li>
              <a class="dropdown-item" href="{{ route('admin.profile') }}">
                <i class="fas fa-user-cog fa-fw me-1"></i>
                <span>@lang('action.profile')</span>
              </a>
            </li>
            <li>
              <a id="logout-action" class="dropdown-item" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt fa-fw me-1"></i>
                <span>@lang('action.logout')</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>

    </div>

  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-white sidebar collapse styled-scrollbar" style="overflow-y: auto">
        <div class="position-sticky pt-3">
          <ul class="list-group list-group-flush">

            <li class="list-group-item mx-2 px-1 py-1">
              <a
                class="nav-link rounded-3 text-nowrap {{ Request::is($adminPrefix) ? $navlinkActiveClass : $navlinkInactiveClass }}"
                href="{{ route('admin') }}"
                @if(Request::is($adminPrefix)) aria-current="page" @endif
                role="button"
              >
                <i class="fas fa-home fa-fw ms-0 ms-xl-1 me-1 me-xl-3"></i>
                <span>@lang('action.dashboard')</span>
              </a>
            </li>

            <li class="list-group-item mx-2 px-1 py-1">
              <a
                class="nav-link rounded-3 text-nowrap {{ Request::is($adminPrefix.'/submissions*') ? $navlinkActiveClass : $navlinkInactiveClass }}"
                href="{{ route('admin.submissions') }}"
                @if(Request::is($adminPrefix.'/submissions*')) aria-current="page" @endif
                role="button"
              >
                <i class="fas fa-inbox fa-fw ms-0 ms-xl-1 me-1 me-xl-3"></i>
                <span>@lang('action.submissions')</span>
              </a>
            </li>

            <li class="list-group-item mx-2 px-1 py-1">
              <a
                class="nav-link rounded-3 text-nowrap {{ Request::is($adminPrefix.'/approvements*') ? $navlinkActiveClass : $navlinkInactiveClass }}"
                href="{{ route('admin.approvements') }}"
                @if(Request::is($adminPrefix.'/approvements*')) aria-current="page" @endif
                role="button"
              >
                <i class="fas fa-tasks fa-fw ms-0 ms-xl-1 me-1 me-xl-3"></i>
                <span>@lang('action.approvements')</span>
              </a>
            </li>

            <li class="list-group-item mx-2 px-1 py-1">
              <a
                class="nav-link rounded-3 text-nowrap {{ Request::is($adminPrefix.'/schedules*') ? $navlinkActiveClass : $navlinkInactiveClass }}"
                href="{{ route('admin.schedules') }}"
                @if(Request::is($adminPrefix.'/schedules*')) aria-current="page" @endif
                role="button"
              >
                <i class="fas fa-calendar-alt fa-fw ms-0 ms-xl-1 me-1 me-xl-3"></i>
                <span>@lang('action.schedules')</span>
              </a>
            </li>

            <li class="list-group-item mx-2 px-1 py-1">
              <a
                class="nav-link rounded-3 text-nowrap {{ Request::is($adminPrefix.'/settings*') || Request::is($adminPrefix.'/profile*') || Request::is($adminPrefix.'/site*') ? $navlinkActiveClass : $navlinkInactiveClass }}"
                href="{{ route('admin.settings') }}"
                @if(Request::is($adminPrefix.'/settings*') || Request::is($adminPrefix.'/profile*') || Request::is($adminPrefix.'/site*')) aria-current="page" @endif
                role="button"
              >
                <i class="fas fa-cog fa-fw ms-0 ms-xl-1 me-1 me-xl-3"></i>
                <span>@lang('action.settings')</span>
              </a>
            </li>

          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        
        @yield('content')

      </main>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function() {
      'use strict'

      $('#show-today-date').html(window.dayjs().format('dddd, D MMMM YYYY'));

      var dropdownUserAction = $('#account-dropdown');
      var dropdownUserActionToggler = $('#navbarDropdownUserAction');

      var dropdownLocale = $('#locale-dropdown');
      var dropdownLocaleToggler = $('#navbarDropdownLocale');

      dropdownUserAction.on('show.bs.dropdown', function(e) {
        dropdownUserActionToggler.toggleClass('active');
      });
      dropdownUserAction.on('hide.bs.dropdown', function(e) {
        dropdownUserActionToggler.toggleClass('active');
      });

      dropdownLocale.on('show.bs.dropdown', function(e) {
        dropdownLocaleToggler.toggleClass('active');
      });
      dropdownLocale.on('hide.bs.dropdown', function(e) {
        dropdownLocaleToggler.toggleClass('active');
      });

      $('#logout-action').click(function(e) {
        e.preventDefault();
        $('#logout-form').submit();
      });

    });
  </script>
@endpush