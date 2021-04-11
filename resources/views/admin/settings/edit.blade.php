@extends('admin.layout')

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', [
      'title' => __('action.profile'),
      'action' => ['back']
    ])

    @includeIf('shared.components.session')

    <div class="p-2 p-md-4 bg-white rounded-3 shadow-sm">
      <div class="p-2">
        <form action="{{ route('admin.profile_update.action') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="d-grid gap-2 mb-4">
            <h2 class="text-center">@lang('typography.update-profile')</h2>
          </div>
          
          {{-- Name --}}
          <div class="mb-3">
            <label for="name" class="form-label">@lang('typography.name')</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? $user['name'] }}" aria-describedby="name-feedback">
            @error('name')
              <div id="name-feedback" class="invalid-feedback">
                {{ $errors->first('name') }}
              </div>
            @enderror
          </div>

          {{-- Email --}}
          <div class="mb-3">
            <label for="email" class="form-label">@lang('typography.email-address')</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? $user['email'] }}" aria-describedby="email-feedback">
            @error('email')
              <div id="email-feedback" class="invalid-feedback">
                {{ $errors->first('email') }}
              </div>
            @enderror
          </div>

          {{-- Spacer --}}
          <div class="mb-3 p-1 p-md-2 p-lg-3"></div>
  
          <div class="mb-1">
            {{-- Submit Button --}}
            <div class="row">
              <div class="col col-12 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-between">
                  <a class="flex-lg-grow-1 btn btn-outline-primary" href="{{ route('admin.profile_update_password') }}">@lang('action.change-password')</a>
                  <button type="submit" class="flex-lg-grow-1 btn btn-primary">@lang('action.save')</button>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>

  </div>
@endsection