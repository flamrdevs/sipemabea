@php
  use Carbon\Carbon;
@endphp

@extends('admin.layout')

@push('css')
  <style>
    .calendar-min-width {
      min-width: 50rem !important;
    }
    .day-flex {
      flex-grow: 1 !important;
      flex-basis: calc(1/7*100%) !important;
    }
    .day-min-height {
      height: 100% !important;
      min-height: 8rem !important;
    }
    .rounded-bl {
      border-bottom-left-radius: 0.45rem !important;
    }
  </style>
@endpush

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', ['title' => __('action.schedules')])

    <div class="d-flex flex-column flex-lg-row justify-content-between my-2 py-2 px-3">
      <div class="flex-grow-1 d-flex justify-content-center align-items-center">
        <span id="month-year-label" class="fs-1"></span>
      </div>
      <div class="d-flex justify-content-between align-items-center">
        <div class="ms-auto"></div>
        {{-- Total In This Month --}}
        <div class="d-flex justify-content-between align-items-center me-2">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary dropdown-toggle styled-focus-box-shadow-none" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
              <i class="fas fa-users fa-fw me-1"></i>
              <span>{{ $totalSubmissionsInMonth['processed'] + $totalSubmissionsInMonth['accepted'] }}</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-end" style="min-width: 5rem;">
              <li>
                <div class="d-flex justify-content-between align-items-center p-2 bg-light text-dark styled-hover-bg-gray-200">
                  <i class="fas fa-clock fa-fw mx-1"></i>
                  <span class="me-2">{{ $totalSubmissionsInMonth['processed'] }}</span>
                </div>
              </li>
              <li>
                <div class="d-flex justify-content-between align-items-center p-2 bg-light text-dark styled-hover-bg-gray-200">
                  <i class="fas fa-check fa-fw mx-1"></i>
                  <span class="me-2">{{ $totalSubmissionsInMonth['accepted'] }}</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
        {{-- Group Type --}}
        <div class="d-flex justify-content-between align-items-center me-2">
          <form id="group-filter-form" action="{{ route('admin.schedules') }}">
            <input type="month" name="month" value="{{ Carbon::parse($monthQuery)->format('Y-m') }}" style="display: none">
            <select class="form-select bg-light border-primary" aria-label="Group Type Select" id="group-filter-action" name="group">
              <option value="1" @if($monthGroupType == "1") selected @endif>@lang('typography.submission-date')</option>
              <option value="2" @if($monthGroupType == "2") selected @endif>@lang('typography.start-date')</option>
            </select>
          </form>
        </div>
        {{-- Month Navigator --}}
        <div class="d-flex justify-content-center align-items-center">
          <div class="btn-group">
            <a href="{{ route('admin.schedules', ['month' => Carbon::parse($monthQuery)->subMonth()->format('Y-m'), 'group' => $monthGroupType]) }}" class="btn btn-outline-primary">
              <i class="fas fa-chevron-left fa-fw mx-1"></i>
            </a>
            <a href="{{ route('admin.schedules', ['month' => Carbon::parse($monthQuery)->addMonth()->format('Y-m'), 'group' => $monthGroupType]) }}" class="btn btn-outline-primary">
              <i class="fas fa-chevron-right fa-fw mx-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="p-4 bg-light overflow-auto">
      @foreach ($month as $week)
        <div class="d-flex justify-content-between calendar-min-width">
          @foreach ($week as $day)
            {{-- header -> ex (mon, tue, wed, .....) --}}
            @if($day['type'] == 'header')
              <div class="day-flex mb-3 p-1 styled-cursor-default">
                <div class="d-flex justify-content-center bg-primary rounded">
                  <span class="fs-3 text-light">
                    {{ __('date.'.$day['value']) }}
                  </span>
                </div>
              </div>
            @endif
            
            {{-- date --}}
            @if($day['type'] == 'date')
              @php
                $processedCount = count($day['value']['submissions']['processed']);
                $acceptedCount = count($day['value']['submissions']['accepted']);
              @endphp
              <div class="day-flex p-1">
                <div class="day-min-height @if($day['value']['is-selected']) @if($processedCount > 0 || $acceptedCount > 0) bg-white @else bg-light @endif shadow-sm rounded-bl @endif">
                  @if($day['value']['is-selected'])
                    <div class="d-flex justify-content-end mx-0 styled-cursor-default">
                      <span class="px-2 py-1 fs-5 @if($day['value']['date']->format('dmy') == Carbon::now()->format('dmy')) bg-primary @else styled-bg-gray-400 @endif text-light rounded-bl">
                        {{ $day['value']['date']->format('d') }}
                      </span>
                    </div>

                    <div class="px-3 py-2">
                      <ul class="list-group list-group-flush">
                        @php
                          $indexOfWeek = $loop->parent->index;
                          $indexOfDay = $loop->index;
                        @endphp
                        @if($processedCount > 0)
                          <li class="list-group-item bg-transparent p-0 px-md-1 py-md-1">
                            <a
                              data-index-of-week="{{ $indexOfWeek }}"
                              data-index-of-day="{{ $indexOfDay }}"
                              data-status-type="processed"
                              class="processed-modal-trigger btn btn-outline-secondary btn-sm w-100 border-0 styled-hover-color-gray-100 styled-hover-sm-swing-ver" href="{{ route('admin.submissions', ['month' => $day['value']['date']->format('Y-m-d')]) }}">
                              <i class="fas fa-clock fa-fw mx-1"></i>
                              <span class="ms-1">{{ $processedCount }}</span>
                            </a>
                          </li>
                        @endif
                        @if($acceptedCount > 0)
                          <li class="list-group-item bg-transparent p-0 px-md-1 py-md-1">
                            <a
                              data-index-of-week="{{ $indexOfWeek }}"
                              data-index-of-day="{{ $indexOfDay }}"
                              data-status-type="accepted"
                              class="accepted-modal-trigger btn btn-outline-success btn-sm w-100 border-0 styled-hover-color-gray-100 styled-hover-sm-swing-ver" href="{{ route('admin.approvements', ['month' => $day['value']['date']->format('Y-m-d')]) }}">
                              <i class="fas fa-check fa-fw mx-1"></i>
                              <span class="ms-1">{{ $acceptedCount }}</span>
                            </a>
                          </li>
                        @endif
                      </ul>
                    </div>
                  @endif
                </div>
              </div>
            @endif
          @endforeach
        </div>
      @endforeach
    </div>

  </div>

  <!-- Modal -->
  <div class="modal fade" id="listModal" tabindex="-1" aria-labelledby="listModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title ps-3 fs-3 fw-bold" id="listModalLabel"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div>
            <ul id="list-container" class="list-group list-group-flush">
            </ul>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">@lang('action.close')</button>
          <button type="button" id="table-view-action" class="btn btn-primary">@lang('action.table-view')</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      var dateForLabel = window.dayjs("{{ Carbon::parse($monthQuery)->format('Y-m-d') }}", 'YYYY-MM-DD').format('MMMM, YYYY');

      $('#month-year-label').html(dateForLabel);

      $('#group-filter-action').change(function () { 
        $('#group-filter-form').submit();
      });

      var month = @json($month);

      var modalData = {
        type: '',
        date: '',
        data: [],
        href: '',
      };

      var listModalEl = document.getElementById('listModal')
      var listModalLabel = $('#listModalLabel');
      var listContainer = $('#list-container');

      var listModal = new window.bootstrap.Modal(listModalEl, {
        backdrop: true,
        keyboard: true,
        focus: true
      });

      listModalEl.addEventListener('hidden.bs.modal', function () {
        modalData.type = '';
        modalData.date = '';
        modalData.data = [];
        modalData.href = '';

        listContainer.empty();
      });

      function updateStateModalData(element) {
        var indexOfWeek = $(element).attr('data-index-of-week');
        var indexOfDay = $(element).attr('data-index-of-day');
        var statusType = $(element).attr('data-status-type');
        var href = $(element).attr('href');

        var selector = {
          indexOfWeek: Number(indexOfWeek),
          indexOfDay: Number(indexOfDay),
          statusType: statusType,
          href: href,
        }

        var day = month[selector.indexOfWeek][selector.indexOfDay]['value'];
        modalData.type = selector.statusType;
        modalData.date = window.dayjs(day['date-string']).format('dddd, DD MMMM YYYY');
        modalData.data = day['submissions'][selector.statusType];
        modalData.href = selector.href;
      }

      function renderModal() {
        listModalLabel.html(modalData.date);

        function renderList() {
          modalData.data.forEach(function (item) {
            var classType = modalData.type == 'accepted' ? 'success' : 'warning';

            var liOpen = '<li class="list-group-item px-1 px-md-3">';
            var liClose = '</li>';

            var aOpen = '<a class="btn btn-outline-' + classType + ' btn-sm w-100 border-0 text-dark styled-hover-color-gray-900 styled-hover-sm-swing-ver" href="' + item.url + '">';
            var aClose = '</a>';

            var person_in_chargeEl = '<div class="d-flex justify-content-start align-items-center fw-bold"><i class="fas fa-user fa-fw me-1"></i>' + item.person_in_charge + '</div>';
            var phone_numberEl = '<div class="d-flex justify-content-start align-items-center"><i class="fas fa-phone fa-fw me-1"></i>' + item.phone_number + '</div>';

            var emailEl = '<div class="d-flex flex-md-row-reverse justify-content-md-start align-items-center"><i class="fas fa-envelope fa-fw me-1 me-md-0 ms-0 ms-md-1"></i>' + item.email + '</div>';
            var agencyEl = '<div class="d-flex flex-md-row-reverse justify-content-md-start align-items-center"><i class="fas fa-house-user fa-fw me-1 me-md-0 ms-0 ms-md-1"></i>' + item.agency + '</div>';

            var startAndEndDate = '<div class="d-flex justify-content-start align-items-center"><i class="fas fa-calendar-alt fa-fw me-1"></i><span>' + dayjs(item.start_date).format('D MMMM YYYY') + '</span><i class="fas fa-minus fa-fw mx-1"></i><span>' + dayjs(item.end_date).format('D MMMM YYYY') + '</span></div>'
            var submissionDate = '<div class="d-flex justify-content-start align-items-center"><i class="fas fa-clock fa-fw me-1"></i><span>' + dayjs(item.created_at).format('D MMMM YYYY - HH:mm:ss') + '</span></div>';

            var leftSide = '<div class="col col-12 col-md-6 col-xl-4"><div class="d-block">' + person_in_chargeEl + phone_numberEl + '</div></div>';
            var rightSide = '<div class="col col-12 col-md-6 col-xl-4"><div class="d-block">' + emailEl + agencyEl + '</div></div>';
            var rightSideHidden = '<div class="d-none d-xl-block col col-xl-4"><div class="d-block">' + startAndEndDate + submissionDate + '</div></div>';
            var card = '<div class="row">' + leftSide + rightSide + rightSideHidden + '</div>';

            var buttonLink = aOpen + card + aClose;

            var child = liOpen + buttonLink + liClose;

            listContainer.append(child);
          });
        }

        renderList();

        listModal.show();
      }

      $('.processed-modal-trigger').click(function (e) { 
        e.preventDefault();
        updateStateModalData($(this));
        renderModal();
      });

      $('.accepted-modal-trigger').click(function (e) { 
        e.preventDefault();
        updateStateModalData($(this));
        renderModal();
      });

      $('#table-view-action').click(function (e) { 
        e.preventDefault();
        window.location.href = modalData.href;
      });
    });
  </script>
@endpush

{{-- Tooltip --}}
{{-- @if($day['value']['is-selected']) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $day['value']['date']->format('d-m-Y') }}" @endif --}}