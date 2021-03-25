@extends('layouts.app')

@section('body')

  <main class="py-5">
    <div class="container my-5">

      <section class="my-5 py-5 rounded-3 shadow">
        <div class="d-flex justify-content-center">
          <div class="p-3">
  
            <div class="my-1 text-center p-2">
              <h1>404</h1>
              <h3>@lang('messages.page-not-found')</h3>
            </div>
  
            <div class="my-1 text-center p-2">
              <a class="btn btn-primary" href="{{ route('welcome') }}" role="button">@lang('action.home')</a>
            </div>
  
          </div>
        </div>
      </section>

    </div>
  </main>

@endsection