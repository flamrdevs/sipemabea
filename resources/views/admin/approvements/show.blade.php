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
      <div class="d-grid gap-2 mb-3">
        <h2 class="text-center">@lang('typography.submission')</h2>
      </div>

      <div class="row mb-3">
        <div class="col col-12 col-md-6 mb-3 mb-md-0">
          <label for="email" class="form-label">
            <i class="fas fa-envelope me-1"></i>
            @lang('typography.email-address')
          </label>
          <input type="email" class="form-control" id="email" value="{{ $submission['email'] }}" disabled>
        </div>
        <div class="col col-12 col-md-6">
          <label for="person-in-charge" class="form-label">
            <i class="fas fa-user me-1"></i>
            @lang('typography.person-in-charge')
          </label>
          <input type="text" class="form-control" id="person-in-charge" value="{{ $submission['person_in_charge'] }}" disabled>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col col-12 col-lg-6 mb-3 mb-lg-0">
          <label for="agency" class="form-label">
            <i class="fas fa-house-user me-1"></i>
            @lang('typography.agency')
          </label>
          <input type="text" class="form-control" id="agency" name="agency" value="{{ $submission['agency'] }}" disabled>
        </div>
        <div class="col col-12 col-md-6 col-lg-3 mb-3 mb-md-0">
          <label for="phone-number" class="form-label">
            <i class="fas fa-phone me-1"></i>
            @lang('typography.phone-number')
          </label>
          <input type="text" class="form-control" id="phone-number" value="{{ $submission['phone_number'] }}" disabled>
        </div>
        <div class="col col-12 col-md-6 col-lg-3">
          <label for="start-date" class="form-label">
            <i class="fas fa-calendar me-1"></i>
            @lang('typography.start-date')
          </label>
          <input type="date" class="form-control" id="start-date" value="{{ date('Y-m-d', strtotime($submission['start_date'])) }}" disabled>
        </div>
      </div>

      <div class="mb-3">
        <label for="goal" class="form-label">
          <i class="fas fa-book-open me-1"></i>
          @lang('typography.goal')
        </label>
        <textarea class="form-control" id="goal" rows="5" disabled>{{ $submission['goal'] }}</textarea>
      </div>

      <div class="row mb-3">
        <div class="col col-12 col-md-6 mb-3 mb-md-0">
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
        <div class="col col-12 col-md-6">
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

      <div class="my-5 p-1 bg-primary rounded"></div>

      <div id="approvement-form" class="p-4 p-md-5 rounded shadow-sm">
        <div class="d-grid gap-2 mb-3">
          <h2 class="text-center">@lang('typography.approvement')</h2>
        </div>

        <div class="row mb-3">
          <div class="col col-12 col-md-6 mb-3 mb-md-0">
            <label for="note" class="form-label">
              <i class="fas fa-sticky-note me-1"></i>
              @lang('typography.note')
            </label>
            <textarea class="form-control" id="note" rows="7" disabled>{{ $submission['note'] }}</textarea>
          </div>
          <div class="col col-12 col-md-6">

            <div class="mb-3">
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

            <div class="mb-3">
              <label for="status" class="form-label">
                <i class="fas fa-info me-1"></i>
                @lang('typography.status')
              </label>
              <div id="status">
                <div class="p-2 @if($submission['status'] === 'accepted') bg-success @else bg-danger @endif text-light rounded text-center">
                  {{ __('messages.'.$submission['status']) }}
                </div>
              </div>
            </div>

            <div class="mb-3">
              @if(!$isEmailSent)
                <form action="{{ route('admin.approvements.resend_approval_mail', ['id' => $submission['id']]) }}" method="POST">
                  @csrf
                  @method('PUT')

                  <div class="mb-3">
                    <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-outline-primary">
                        @lang('action.resend-email')
                      </button>
                    </div>
                  </div>
                </form>
              @endif
            </div>

          </div>
        </div>
      </div>

    </div>

  </div>
@endsection