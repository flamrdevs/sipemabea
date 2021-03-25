@extends('layouts.app')

@section('body')
  <main class="py-md-4">
    <div class="container">

      <section class="py-3">
        <div class="row">
  
            <div class="col col-12 col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xxl-4 offset-xxl-4">

              @includeIf('shared.components.session')

              <div class="p-5 bg-white rounded-3 shadow">
                <form action="{{ route('reset_password.action') }}" method="POST">
                  @csrf
                  
                  <div class="d-grid gap-2 mb-3">
                    <h2 class="text-center">@lang('typography.reset-password')</h2>
                  </div>

                  <input type="email" name="email" value="{{ $data['email']}}" style="display: none">
                  <input type="string" name="token" value="{{ $data['token']}}" style="display: none">
    
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
    
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">@lang('action.reset')</button>
                  </div>
                </form>
              </div>

            </div>

        </div>
      </section>

    </div>
  </main>
@endsection