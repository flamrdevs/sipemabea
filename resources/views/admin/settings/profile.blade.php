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
        <div class="mb-3">
          <label for="name" class="form-label">@lang('typography.name')</label>
          <input type="text" class="form-control" id="name" value="{{ $user['name'] }}" disabled>
        </div>
  
        <div class="mb-3">
          <label for="email" class="form-label">@lang('typography.email-address')</label>
          <input type="email" class="form-control" id="email" value="{{ $user['email'] }}" disabled>
        </div>
  
        {{-- Spacer --}}
        <div class="mb-3 p-1 p-md-2 p-lg-3"></div>
  
        <div class="mb-1">
          <div class="row">
            <div class="col col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-2 offset-xl-5">
              <div class="d-grid gap-2">
                <a class="btn btn-primary" href="{{ route('admin.profile_update') }}">@lang('action.change-profile')</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
@endsection