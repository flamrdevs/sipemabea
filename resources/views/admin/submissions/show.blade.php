@extends('admin.layout')

@section('content')
  <div class="container my-4 p-1 p-md-2">

    @includeIf('shared.components.banner', [
      'title' => __('action.submissions'),
      'action' => ['back'],
    ])

    @includeIF('shared.components.session')

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
        <form action="{{ route('admin.submissions.update', ['id' => $submission['id']]) }}" method="POST" enctype="multipart/form-data" autofocus>
          @csrf
          @method('PUT')

          <div class="d-grid gap-2 mb-3">
            <h2 class="text-center">@lang('typography.approvement')</h2>
          </div>

          <div class="row mb-3">
            <div class="col col-12 col-md-6 mb-3 mb-md-0">
              <label for="note" class="form-label">
                <i class="fas fa-sticky-note me-1"></i>
                @lang('typography.note')
              </label>
              <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note" rows="7" aria-describedby="note-feedback">{{ old('note') }}</textarea>
              @error('note')
                <div id="note-feedback" class="invalid-feedback">
                  {{ $errors->first('note') }}
                </div>
              @enderror
            </div>
            <div class="col col-12 col-md-6">

              <div class="mb-3">
                <label for="attachment-link" class="form-label">
                  <i class="fas fa-file-pdf me-1"></i>
                  @lang('typography.attachment-file')
                </label>
                <input type="file" class="form-control @error('attachment-link') is-invalid @enderror" id="attachment-link" name="attachment-link" aria-describedby="attachment-link-feedback">
                @error('attachment-link')
                  <div id="attachment-link-feedback" class="invalid-feedback">
                    {{ $errors->first('attachment-link') }}
                  </div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="status" class="form-label">
                  <i class="fas fa-info me-1"></i>
                  @lang('typography.status')
                </label>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end form-control @error('status') is-invalid py-0 ps-0 @else p-0 @enderror">
                  <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="status" id="status-rejected" value="rejected" autocomplete="off" aria-describedby="status-feedback" @if(old('status') === 'rejected') checked @endif>
                    <label class="btn btn-outline-danger border-0" for="status-rejected">@lang('action.reject')</label>
                  
                    <input type="radio" class="btn-check" name="status" id="status-accepted" value="accepted" autocomplete="off" aria-describedby="status-feedback" @if(old('status') === 'accepted') checked @endif>
                    <label class="btn btn-outline-success border-0" for="status-accepted">@lang('action.accept')</label>
                  </div>
                </div>
                @error('status')
                  <div id="status-feedback" class="invalid-feedback">
                    {{ $errors->first('status') }}
                  </div>
                @enderror
              </div>

            </div>
          </div>

          <div class="my-3 p-1"></div>

          <div class="mb-3">
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

@if($errors->any())
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