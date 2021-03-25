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
        <form action="{{ route('admin.profile_update_password.action') }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="d-grid gap-2 mb-3">
            <h2 class="text-center">@lang('typography.update-password')</h2>
          </div>
  
          <div class="mb-3">
            <label for="current-password" class="form-label">@lang('typography.current-password')</label>
            <input type="password" class="form-control @if(Session::has('failure-current-password')) is-invalid @endif @error('current-password') is-invalid @enderror" id="current-password" name="current-password" value="{{ old('current-password') }}" aria-describedby="current-password-feedback">
            @error('current-password')
              <div id="current-password-feedback" class="invalid-feedback">
                {{ $errors->first('current-password') }}
              </div>
            @enderror
          </div>
  
          <div class="mb-3">
            <label for="new-password" class="form-label">@lang('typography.new-password')</label>
            <input type="password" class="form-control @error('new-password') is-invalid @enderror" id="new-password" name="new-password" value="{{ old('new-password') }}" aria-describedby="new-password-feedback">
            @error('new-password')
              <div id="new-password-feedback" class="invalid-feedback">
                {{ $errors->first('new-password') }}
              </div>
            @enderror
          </div>
  
          <div class="mb-3">
            <label for="new-password-confirmation" class="form-label">@lang('typography.new-password-confirmation')</label>
            <input type="password" class="form-control @error('new-password-confirmation') is-invalid @enderror" id="new-password-confirmation" name="new-password-confirmation" aria-describedby="new-password-confirmation-feedback">
            @error('new-password-confirmation')
              <div id="new-password-confirmation-feedback" class="invalid-feedback">
                {{ $errors->first('new-password-confirmation') }}
              </div>
            @enderror
          </div>
  
          <div class="my-3 p-1"></div>
  
          <div class="mb-1">
            <div class="row">
              <div class="col col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-2 offset-xl-5">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary">@lang('action.save')</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection