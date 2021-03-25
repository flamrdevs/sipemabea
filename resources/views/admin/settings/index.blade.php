@extends('admin.layout')

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', ['title' => __('action.settings')])

    <div class="p-2 p-md-4 bg-white rounded-3 shadow-sm">
      <div class="row">
        <div class="col col-12 col-md-12">
          <ul class="list-group list-group-flush">
            <li class="list-group-item mx-2 px-1 py-2">
              <a class="nav-link rounded-3 text-dark styled-hover-bg-gray-200" href="{{ route('admin.profile') }}" role="button">
                <i class="fas fa-user-cog fa-fw ms-1 me-2"></i>
                <span>@lang('action.profile')</span>
              </a>
            </li>
            <li class="list-group-item mx-2 px-1 py-2">
              <a class="nav-link rounded-3 text-dark styled-hover-bg-gray-200" href="{{ route('admin.site') }}" role="button">
                <i class="fas fa-desktop fa-fw ms-1 me-2"></i>
                <span>@lang('action.site')</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

  </div>
@endsection