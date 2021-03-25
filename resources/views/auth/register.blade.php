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
              <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="d-grid gap-2 mb-3">
                  <h2 class="text-center">@lang('typography.register')</h2>
                </div>

                <div class="mb-3">
                  <label for="name" class="form-label">@lang('typography.name')</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" aria-describedby="name-feedback">
                  @error('name')
                    <div id="name-feedback" class="invalid-feedback">
                      {{ $errors->first('name') }}
                    </div>
                  @enderror
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
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" aria-describedby="password-feedback">
                  @error('password')
                    <div id="password-feedback" class="invalid-feedback">
                      {{ $errors->first('password') }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="password-confirmation" class="form-label">@lang('typography.password-confirmation')</label>
                  <input type="password" class="form-control @error('password-confirmation') is-invalid @enderror" id="password-confirmation" name="password-confirmation" aria-describedby="password-confirmation-feedback">
                  @error('password-confirmation')
                    <div id="password-confirmation-feedback" class="invalid-feedback">
                      {{ $errors->first('password-confirmation') }}
                    </div>
                  @enderror
                </div>

                <div class="mb-3 d-flex">
                  <span>
                    @lang('typography.already-have-an-account')
                    <a href="{{ route('login') }}" class="link-primary text-decoration-none">@lang('action.login')</a>
                  </span>
                </div>
  
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">@lang('action.register')</button>
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