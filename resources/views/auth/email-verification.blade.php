@extends('layouts.app')

@section('body')
  @includeIf('shared.header')

  <main class="p-5">
    <div class="container">

      <section class="py-3">
        <div class="row">
  
            <div class="col col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">

              @includeIf('shared.components.session')

              <div class="p-5 bg-white rounded-3 shadow">
                <form action="{{ route('login') }}" method="POST">
                  @csrf
                  
                  <div class="d-grid gap-2 mb-3">
                    <h2 class="text-center">@lang('typography.login')</h2>
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
                    <label for="password" class="form-label">@lang('typography.password')</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" aria-describedby="password-feedback">
                    @error('password')
                      <div id="password-feedback" class="invalid-feedback">
                        {{ $errors->first('password') }}
                      </div>
                    @enderror
                  </div>

                  <div class="mb-3 d-flex justify-content-end">
                    <a href="#" class="link-primary text-decoration-none">@lang('action.forgot-password')</a>
                  </div>

                  <div class="mb-3 d-flex">
                    <span>
                      @lang('typography.do-not-have-an-account-yet')
                      <a href="{{ route('register') }}" class="link-primary text-decoration-none">@lang('action.register')</a>
                    </span>
                  </div>
    
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">@lang('action.login')</button>
                  </div>
                </form>
              </div>

            </div>

        </div>
      </section>

    </div>
  </main>

  @includeIf('shared.footer')
@endsection