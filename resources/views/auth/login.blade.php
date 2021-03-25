@extends('layouts.app')

@section('body')
  <main class="py-md-4">
    <div class="container">

      <section class="py-3">
        <div class="row">
  
          <div class="col col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">

            @includeIf('shared.components.session')

            <div class="p-5 bg-white rounded-3 shadow">
              <form action="{{ route('login.action') }}" method="POST">
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
                  <a href="{{ route('forgot_password') }}" class="link-primary text-decoration-none">@lang('action.forgot-password')</a>
                </div>

                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="remember" id="remember-me" name="remember-me">
                    <label class="form-check-label" for="remember-me">
                      @lang('action.remember-me')
                    </label>
                  </div>
                </div>

                <div class="mb-3 p-1"></div>

                <div class="mb-3">
                  <div class="row">
                    <div class="col col-12 col-md-6 offset-md-3">
                      <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">@lang('action.login')</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>

          </div>

        </div>
      </section>

    </div>
  </main>
@endsection