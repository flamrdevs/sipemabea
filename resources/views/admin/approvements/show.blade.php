@extends('admin.layout')

@section('content')
  <div class="container my-4 p-1 p-md-2">

    @includeIf('shared.components.banner', [
      'title' => __('action.approvements'),
      'action' => ['back'],
    ])

    @includeIF('shared.components.session')

    @if(Session::has('mail-success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span>{{ Session::get('mail-success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(Session::has('mail-failure'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span>{{ Session::get('mail-failure') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(Session::has('mail-service-error'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <span class="fw-bold">{{ Session::get('mail-service-error') }}.</span>
        <span>@lang('messages.try-again-later')</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="p-4 p-md-5 bg-white rounded-3 shadow">

      <div class="d-grid gap-2 mb-4">
        <h2 class="text-center">@lang('typography.submission')</h2>
      </div>

      <div class="row mb-3">
        {{-- Email --}}
        <div class="col col-12 col-lg-6 mb-3 mb-lg-0">
          <label for="email" class="form-label">
            <i class="fas fa-envelope me-1"></i>
            @lang('typography.email-address')
          </label>
          <input type="email" class="form-control" id="email" value="{{ $submission['email'] }}" disabled>
        </div>
        {{-- Agency --}}
        <div class="col col-12 col-lg-6">
          <label for="agency" class="form-label">
            <i class="fas fa-house-user me-1"></i>
            @lang('typography.agency')
          </label>
          <input type="text" class="form-control" id="agency" name="agency" value="{{ $submission['agency'] }}" disabled>
        </div>
      </div>

      <div class="row mb-3">
        {{-- Person In Charge --}}
        <div class="col col-12 col-md-6 col-lg-5 mb-3 mb-lg-0">
          <label for="person-in-charge" class="form-label">
            <i class="fas fa-user me-1"></i>
            @lang('typography.person-in-charge')
          </label>
          <input type="text" class="form-control" id="person-in-charge" value="{{ $submission['person_in_charge'] }}" disabled>
        </div>
        {{-- Phone Number --}}
        <div class="col col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
          <label for="phone-number" class="form-label">
            <i class="fas fa-phone me-1"></i>
            @lang('typography.phone-number')
          </label>
          <input type="text" class="form-control" id="phone-number" value="{{ $submission['phone_number'] }}" disabled>
        </div>
        {{-- Member --}}
        <div class="col col-12 col-md-6 offset-md-6 col-lg-4 offset-lg-0">
          <div id="dynamic-member-form" class="row">
            @php
              $members = json_decode($submission['members']);
            @endphp
            {{-- @if($members->isNotEmpty()) --}}
              @foreach($members as $member)
                <div class="col col-12 @if(!$loop->last) mb-2 @endif">
                  @if($loop->iteration == 1)
                    <label for="member-1" class="form-label">
                      <i class="fas fa-users me-1"></i>
                      @lang('typography.member')
                    </label>
                  @endif
                  <input type="text" class="form-control" id="member-{{ $loop->iteration }}" value="{{ $member }}" disabled>
                </div>
              @endforeach
            {{-- @else
              <div class="col col-12 mb-2">
                <label for="member-1" class="form-label">
                  <i class="fas fa-users me-1"></i>
                  @lang('typography.member')
                </label>
                <input type="text" class="form-control member-field-counter" id="member-1" name="member[]">
              </div>
            @endif --}}
          </div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col col-12 col-lg-8 col-xxl-5">
          <div class="row">
            {{-- Start Date --}}
            <div class="col col-12 col-sm-6 col-lg-12 col-xl-6 mb-3 mb-sm-0 mb-lg-3 mb-xl-0">
              <label for="start-date" class="form-label">
                <i class="fas fa-calendar me-1"></i>
                @lang('typography.start-date')
              </label>
              <input type="date" class="form-control" id="start-date" value="{{ $submission['start_date']->format('Y-m-d') }}" disabled>
            </div>
            {{-- End Date --}}
            <div class="col col-12 col-sm-6 col-lg-12 col-xl-6">
              <label for="end-date" class="form-label">
                <i class="fas fa-calendar me-1"></i>
                @lang('typography.end-date')
              </label>
              <input type="date" class="form-control" id="end-date" value="{{ $submission['end_date']->format('Y-m-d') }}" disabled>
            </div>
          </div>
        </div>
      </div>

      <div class="row mb-3">
        {{-- Goal --}}
        <div class="col col-12 col-lg-8">
          <label for="goal" class="form-label">
            <i class="fas fa-book-open me-1"></i>
            @lang('typography.goal')
          </label>
          <textarea class="form-control" id="goal" rows="5" disabled>{{ $submission['goal'] }}</textarea>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col col-12 col-lg-8">
          <div class="row">
            {{-- Proposal --}}
            <div class="col col-12 col-xl-6 mb-3 mb-xl-0">
              <label for="proposal-link" class="form-label">
                <i class="fas fa-file-pdf me-1"></i>
                @lang('typography.proposal-file')
              </label>
              <div class="input-group flex-nowrap">
                <a id="proposal-link-action" class="btn btn-outline-primary" href="{{ route('download', ['location' => base64_encode($submission['proposal_link'])]) }}" role="button" rel="nofollow">
                  <i class="fas fa-file-download fa-fw mx-1"></i>
                </a>
                <input type="text" class="form-control" id="proposal-link" value="{{ Helper::getOriginalFileName($submission['proposal_link']) }}" aria-describedby="proposal-link-action" disabled>
              </div>
            </div>
            {{-- Cover Letter --}}
            <div class="col col-12 col-xl-6">
              <label for="cover-letter-link" class="form-label">
                <i class="fas fa-file-pdf me-1"></i>
                @lang('typography.cover-letter-file')
              </label>
              <div class="input-group flex-nowrap">
                <a id="cover-letter-link-action" class="btn btn-outline-primary" href="{{ route('download', ['location' => base64_encode($submission['cover_letter_link'])]) }}" role="button" rel="nofollow">
                  <i class="fas fa-file-download fa-fw mx-1"></i>
                </a>
                <input type="text" class="form-control" id="cover-letter-link" value="{{ Helper::getOriginalFileName($submission['cover_letter_link']) }}" aria-describedby="cover-letter-link-action" disabled>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Spacer --}}
      <div class="my-5 p-1 bg-primary rounded"></div>

      <div id="approvement-form" class="p-3 p-md-4 rounded shadow-sm">

        <div class="d-grid gap-2 mb-4">
          <h2 class="text-center">@lang('typography.approvement')</h2>
        </div>

        <div class="row mb-3">
          {{-- Note --}}
          <div class="col col-12 col-xxl-7 mb-3 mb-xxl-0">
            <label for="note" class="form-label">
              <i class="fas fa-sticky-note me-1"></i>
              @lang('typography.note')
            </label>
            <textarea class="form-control" id="note" rows="12" disabled>{{ $submission['note'] }}</textarea>
          </div>
          <div class="col col-12 col-xxl-5">
            <div class="row">
              {{-- Attachment --}}
              <div class="col col-12 col-lg-8 col-xxl-12 mb-3 mb-lg-0 mb-xxl-3">
                <label for="attachment-link" class="form-label">
                  <i class="fas fa-file-pdf me-1"></i>
                  @lang('typography.attachment-file')
                </label>
                <div class="input-group flex-nowrap">
                  <a id="attachment-link-action" class="btn btn-outline-primary" href="{{ route('download', ['location' => base64_encode($submission['attachment_link'])]) }}" role="button" rel="nofollow">
                    <i class="fas fa-file-download fa-fw mx-1"></i>
                  </a>
                  <input type="text" class="form-control" id="attachment-link" value="{{ Helper::getOriginalFileName($submission['attachment_link']) }}" aria-describedby="attachment-link-action" disabled>
                </div>
              </div>
              {{-- Status --}}
              <div class="col col-12 col-lg-4 col-xxl-12">
                <label for="status" class="form-label">
                  <i class="fas fa-info me-1"></i>
                  @lang('typography.status')
                </label>
                <div id="status">
                  <div class="p-2 @if($submission['status'] === 'accepted') bg-success @else bg-danger @endif text-light rounded text-center">
                    <i class="fas @if($submission['status'] === 'accepted') fa-check @else fa-times @endif me-1"></i>
                    {{ __('messages.'.$submission['status']) }}
                  </div>
                </div>
              </div>

            </div>
          </div>

          @if(!$isEmailSent)
            {{-- Spacer --}}
            <div class="mb-3 p-1 p-md-2 p-lg-3"></div>

            <div class="mb-3">
              {{-- Submit Button --}}
              <div class="row">
                <div class="col col-12 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                  <div class="d-grid gap-2">
                    <a class="btn btn-primary" href="{{ route('admin.approvements.mail-preview', ['id' => $submission['id']]) }}" role="button">
                      <i class="fas fa-redo-alt me-1"></i>
                      @lang('action.resend-email')
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endif

        </div>

      </div>

    </div>

  </div>
@endsection

@if(!$isEmailSent)
  @push('script')
    <script>
      $(document).ready(function () {
        $('html, body').animate({
          scrollTop: ($('#approvement-form').offset().top)
        }, 50);
      });
    </script>
  @endpush
@endif