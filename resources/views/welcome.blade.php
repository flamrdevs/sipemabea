@php
  $ui = Helper::getStaticJson()['ui'];
@endphp

@extends('layouts.app')

@section('body')
  @includeWhen($ui['header'] ,'shared.header')

  <main class="py-md-4">
    <div class="container">

      <section class="py-3">
        <div class="container my-4">
          <div class="d-flex justify-content-center">
            
            <div class="p-5 bg-white rounded-3 shadow flex-grow-1">
              
              <div class="my-2 text-center p-2">
                <h1 class="fs-2">Sipemabea</h1>
              </div>
              
              <div class="my-2 text-center p-2">
                <p class="fs-5 m-auto" style="max-width: 40rem">Sipemabea adalah sistem penerimaan magang <strong>Bea Cukai Jember</strong> berbasis website yang digunakan untuk memudahkan pendaftaran magang</p>
              </div>
              
            </div>
            
          </div>
        </div>
      </section>

      <section class="py-3">
        <div class="container my-4">
          <div class="d-flex justify-content-center">

            <div class="p-4 p-md-5 bg-white rounded-3 shadow flex-grow-1">

              <div class="p-1">
                <img class="w-100 rounded-3" src="{{ asset('images/alur.png') }}" alt="alur pengajuan">
              </div>

              <div class="my-1 pt-4">
                <div class="row">
                  <div class="col col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-2 offset-xl-5">
                    <div class="d-grid gap-2">
                      <a class="btn btn-primary" href="{{ route('submission') }}" role="button">
                        @lang('action.submit-now')
                      </a>
                    </div>
                  </div>
                </div>
              </div>
    
            </div>
            
          </div>
        </div>
      </section>

    </div>
  </main>

  @includeWhen($ui['footer'], 'shared.footer')
@endsection