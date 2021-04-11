@php
  use Carbon\Carbon;
@endphp

@extends('admin.layout')

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', ['title' => __('action.submissions')])

    <div class="p-4 bg-white rounded-3 shadow-sm">

      <div class="d-flex justify-content-between mb-3 p-2">
        <div class="ms-auto">
          <label for="month-filter-action" class="d-block mb-1 fw-bold">@lang('typography.month')</label>
          <div class="d-flex justify-content-between border border-3 border-dark rounded">
            @isset($monthQuery)
              <div class="d-flex align-items-center ms-1">
                <a class="btn btn-outline-dark btn-sm border-0 styled-focus-box-shadow-none" href="{{ route('admin.submissions') }}">
                  <i class="fas fa-eraser fa-fw"></i>
                </a>
              </div>
            @endisset
            <form id="month-filter-form" action="{{ route('admin.submissions') }}" method="GET">
              <div>
                <input type="month" class="form-control border-0 styled-focus-box-shadow-none" id="month-filter-action" name="month" @isset($monthQuery) value="{{ Carbon::parse($monthQuery)->format('Y-m') }}" @endisset>
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
              <th class="text-nowrap" scope="col">@lang('typography.person-in-charge')</th>
              <th class="text-nowrap" scope="col">@lang('typography.agency')</th>
              <th class="text-nowrap" scope="col">@lang('typography.phone-number')</th>
              <th class="text-nowrap" scope="col">@lang('typography.submission-date')</th>
              <th class="text-nowrap" scope="col">@lang('typography.start-date')</th>
              <th class="text-nowrap" scope="col">@lang('typography.end-date')</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($submissions as $submission)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $submission['person_in_charge'] }}</td>
                <td>{{ $submission['agency'] }}</td>
                <td>{{ $submission['phone_number'] }}</td>
                <td>{{ $submission['created_at']->isoFormat('DD MMMM Y') }}</td>
                <td>{{ $submission['start_date']->isoFormat('DD MMMM Y') }}</td>
                <td>{{ $submission['end_date']->isoFormat('DD MMMM Y') }}</td>
                <td style="width: 4rem">
                  <div class="d-flex gap-2 justify-content-between">
                    @if($submission['status'] === 'processed')
                      <span class="text-secondary">
                        <i class="fas fa-clock fa-fw mx-1"></i>
                      </span>
                    @endif
                    <a class="btn btn-outline-info btn-sm p-0 ms-auto styled-hover-sm-swing-ver" href="{{ route('admin.submissions.show', ['id' => $submission['id']]) }}" role="button">
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
              'items' => __('typography.submission') ,
            ])
          </p>
          <nav aria-label="Paginate submissions" class="d-flex justify-content-end d-md-block">
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
      $('#month-filter-action').change(function (e) { 
        e.preventDefault();
        $('#month-filter-form').submit();
      });
    });
  </script>
@endpush