@php
  use Carbon\Carbon;
  function statusClass($test) {
    switch ($test) {
      case 'processed':
        return 'bg-info';
      case 'accepted':
        return 'bg-success';
      case 'rejected':
        return 'bg-danger';
      default:
        return 'bg-info';
    }
  }
@endphp

@extends('admin.layout')

@push('css')
  <style>
    .outline-none {
      outline: none !important;
    }
    .border-none {
      border: none !important;
    }
  </style>
@endpush

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', ['title' => __('action.approvements')])

    <div class="p-4 bg-white rounded-3 shadow-sm">

      <div class="d-flex justify-content-between mb-3 p-2">
        <div class="ms-auto">
          <label for="date-filter-action" class="d-block mb-1">@lang('typography.start-date')</label>
          <div class="d-flex justify-content-between border border-3 border-dark rounded">
            @isset($dateQuery)
              <div class="d-flex align-items-center ms-1">
                <a class="btn btn-outline-dark btn-sm border-0 styled-focus-box-shadow-none" href="{{ route('admin.approvements') }}">
                  <i class="fas fa-eraser fa-fw"></i>
                </a>
              </div>
            @endisset
            <form id="date-filter-form" action="{{ route('admin.approvements') }}" method="GET">
              <div>
                <input type="date" class="form-control border-0 styled-focus-box-shadow-none" id="date-filter-action" name="date" @isset($dateQuery) value="{{ Carbon::parse($dateQuery)->format('Y-m-d') }}" @endisset>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="table-responsive styled-scrollbar">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th class="text-norwap" scope="col">@lang('typography.email')</th>
              <th class="text-norwap" scope="col">@lang('typography.person-in-charge')</th>
              <th class="text-norwap" scope="col">@lang('typography.agency')</th>
              <th class="text-norwap" scope="col">@lang('typography.phone-number')</th>
              <th class="text-nowrap" scope="col">@lang('typography.start-date')</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($submissions as $submission)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $submission['email'] }}</td>
                <td>{{ $submission['person_in_charge'] }}</td>
                <td>{{ $submission['agency'] }}</td>
                <td>{{ $submission['phone_number'] }}</td>
                <td>{{ date('d-m-Y', strtotime($submission['start_date'])) }}</td>
                <td style="width: 10rem">
                  <div class="d-flex gap-2 justify-content-between">
                    <span class="lh-sm badge {{ statusClass($submission['status']) }}">
                      {{ __('messages.'.$submission['status']) }}
                    </span>
                    @if(!$submission['email_sent'])
                      <span class="ms-auto text-danger">
                        <i class="fas fa-exclamation fa-fw"></i>
                      </span>
                    @endif
                    <a class="btn btn-outline-info btn-sm p-0 styled-hover-sm-swing-ver" href="{{ route('admin.approvements.show', ['id' => $submission['id']]) }}" role="button">
                      <i class="fas fa-chevron-right fa-fw mx-1"></i>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <th class="text-center" scope="row" colspan="7">@lang('typography.no-data')</th>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if(method_exists($submissions, 'links') && $submissions->total() > 0)
        <div class="d-flex justify-content-between flex-column flex-md-row mt-3">
          <p>
            @lang('typography.display-from-to-of-total-items', [
              'from' => '1',
              'to' => $submissions->perPage() < $submissions->total() ? $submissions->perPage() : $submissions->total(),
              'total' => $submissions->total(),
              'items' => __('typography.approvement') ,
            ])
          </p>
          <nav aria-label="Paginate approvements" class="d-flex justify-content-end d-md-block">
            {{ $submissions->links() }}
          </nav>
        </div>
      @endif
      
    </div>
    
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      $('#date-filter-action').change(function (e) { 
        e.preventDefault();
        $('#date-filter-form').submit();
      });
    });
  </script>
@endpush