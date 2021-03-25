@extends('layouts.app')

@section('body')
  <main class="py-md-4">
    <div class="container">

      <section class="py-3">
        <div class="row">
  
            <div class="col col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">

              @if(Session::has('mail-failure'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span>{{ Session::get('mail-failure') }}</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              
              @if(Session::has('mail-service-error'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <span class="fw-bold">{{ Session::get('mail-service-error') }}.</span>
                  <span>@lang('messages.try-again-later')</span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              @if (Session::has('success'))
                <div class="p-5 bg-white rounded-3 shadow">
                  <h2>{{ Session::get('success') }}</h2>
                </div>
              @else
                <div class="p-5 bg-white rounded-3 shadow">
                  <form action="{{ route('forgot_password.action') }}" method="POST">
                    @csrf
                    
                    <div class="d-grid gap-2 mb-3">
                      <h2 class="text-center">@lang('typography.forgot-password')</h2>
                    </div>
      
                    <div class="mb-3">
                      <label for="email" class="form-label">@lang('typography.email-address')</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" aria-describedby="email-feedback">
                      @error('email')
                        <div id="email-feedback" class="invalid-feedback">
                          {{ $errors->first('email') }}
                        </div>
                      @enderror
                    </div>

                    <div class="mb-3">
                      <p>@lang('typography.a-password-reset-link-will-be-e-mailed-to-you')</p>
                    </div>
      
                    <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-primary">@lang('action.send')</button>
                    </div>
                  </form>
                </div>
              @endif

            </div>

        </div>
      </section>

    </div>
  </main>
@endsection