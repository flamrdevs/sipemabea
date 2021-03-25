@php
  use Carbon\Carbon;
@endphp

@extends('admin.layout')

@section('content')
  <div class="container my-4 p-2">
    
    @includeIf('shared.components.banner', ['title' => __('action.dashboard')])

    <div class="row mb-2">

      <div class="col col-12 col-sm-6">
        <div class="my-2 p-3 p-md-4 bg-white rounded-3 shadow-sm">
          <div class="d-flex justify-content-between mb-2">
            <div class="fs-2 fw-bold">
              @lang('action.submissions')
            </div>
            <div class="fs-2 fw-bold">
              {{ count($data['unread']) + count($data['processed']) }}
            </div>
          </div>
          <div class="my-1 p-2">
            <ul class="list-group fs-5">
              <li class="list-group-item d-flex justify-content-between align-items-center styled-hover-bg-gray-100">
                <div>
                  <i class="fas fa-inbox fa-fw me-1"></i>
                  <span>@lang('typography.new')</span>
                </div>
                <span class="badge bg-info rounded-pill">{{ count($data['unread']) }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center styled-hover-bg-gray-100">
                <div>
                  <i class="fas fa-clock fa-fw me-1"></i>
                  <span>@lang('typography.processed')</span>
                </div>
                <span class="badge bg-primary rounded-pill">{{ count($data['processed']) }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col col-12 col-sm-6">
        <div class="my-2 p-3 p-md-4 bg-white rounded-3 shadow-sm">
          <div class="d-flex justify-content-between mb-2">
            <div class="fs-2 fw-bold">
              @lang('action.approvements')
            </div>
            <div class="fs-2 fw-bold">
              {{ count($data['rejected']) + count($data['accepted']) }}
            </div>
          </div>
          <div class="my-1 p-2">
            <ul class="list-group fs-5">
              <li class="list-group-item d-flex justify-content-between align-items-center styled-hover-bg-gray-100">
                <div>
                  <i class="fas fa-times fa-fw me-1"></i>
                  <span>@lang('typography.rejected')</span>
                </div>
                <span class="badge bg-danger rounded-pill">{{ count($data['rejected']) }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center styled-hover-bg-gray-100">
                <div>
                  <i class="fas fa-check fa-fw me-1"></i>
                  <span>@lang('typography.accepted')</span>
                </div>
                <span class="badge bg-success rounded-pill">{{ count($data['accepted']) }}</span>
              </li>
            </ul>
          </div>
        </div>
      </div>

    </div>

    @php
      $submissions = array_collapse([$data['processed'], $data['unread']])
    @endphp
    @if(count($submissions) > 0)
      <div class="row">
        <div class="col col-12">
          <div class="my-2 p-3 p-md-4 bg-white rounded-3 shadow-sm">
            <div class="fs-5 fw-bold">
              Pengajuan hari ini
            </div>
            <div>
              <ul class="list-group list-group-flush">
                @foreach ($submissions as $processed)
                  @if ($processed['created_at']->format('dmy') == Carbon::now()->format('dmy'))
                    <li class="list-group-item bg-transparent p-1 p-md-3">
                      <a class="btn btn-outline-primary btn-sm w-100 border-0 text-dark styled-hover-color-gray-100 styled-hover-sm-swing-ver" href="{{ route('admin.submissions.show', ['id' => $processed['id']]) }}">
                        <div class="row">
                          <div class="col col-12 col-md-6 col-lg-4">
                            <div class="d-block">
                              <div class="d-flex justify-content-start align-items-center fw-bold">
                                <i class="fas fa-user fa-fw me-1"></i>
                                {{ $processed['person_in_charge'] }}
                              </div>
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fas fa-phone fa-fw me-1"></i>
                                {{ $processed['phone_number'] }}
                              </div>
                            </div>
                          </div>
                          <div class="col col-12 col-md-6 col-lg-4">
                            <div class="d-block">
                              <div class="d-flex flex-md-row-reverse justify-content-md-start align-items-center">
                                <i class="fas fa-envelope fa-fw me-1 me-md-0 ms-0 ms-md-1"></i>
                                {{ $processed['email'] }}
                              </div>
                              <div class="d-flex flex-md-row-reverse justify-content-md-start align-items-center">
                                <i class="fas fa-house-user fa-fw me-1 me-md-0 ms-0 ms-md-1"></i>
                                {{ $processed['agency'] }}
                              </div>
                            </div>
                          </div>
                          <div class="d-none d-lg-block col col-12 col-lg-4">
                            <div class="d-block">
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fas fa-calendar-alt fa-fw me-1"></i>
                                <span>{{ Carbon::parse($processed['start_date'])->format('d-m-Y') }}</span>
                              </div>
                              <div class="d-flex justify-content-start align-items-center">
                                <i class="fas fa-clock fa-fw me-1"></i>
                                <span>{{ $processed['created_at']->format('H:i:s') }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </a>
                    </li>
                  @endif
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    @endif

  </div>
@endsection