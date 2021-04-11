@php
  use Carbon\Carbon;
  $ui = Helper::getStaticJson()['ui'];
@endphp

@extends('layouts.app')

@section('body')
  @includeWhen($ui['header'] ,'shared.header')

  <main class="py-md-4">
    <div class="container">

      <section class="py-3">
        <div class="container my-4">

          @if (Session::has('success'))
            <div class="mb-5 p-5 bg-white rounded-3 shadow">
              <h1 class="font-weight-bold mb-3">
                {{ Session::get('success') }}
              </h1>
              <h5>@lang('messages.thank-you-for-register')</h5>
              <h5>@lang('messages.a-confirmation-email-will-be-sent-to', ['email' => Session::get('email')])</h5>
            </div>
          @elseif (Session::has('failure'))
            <div class="mb-5 p-5 bg-white rounded-3 shadow">
              <h1 class="font-weight-bold mb-3">
                {{ Session::get('failure') }}
              </h1>
              <h5>@lang('messages.sorry')</h5>
              <h5>@lang('messages.try-again-later')</h5>
            </div>
          @else
      
            <div class="p-4 p-md-5 bg-white rounded-3 shadow">
              <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
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
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" aria-describedby="email-feedback">
                    @error('email')
                      <div id="email-feedback" class="invalid-feedback">
                        {{ $errors->first('email') }}
                      </div>
                    @enderror
                  </div>
                  {{-- Agency --}}
                  <div class="col col-12 col-lg-6">
                    <label for="agency" class="form-label">
                      <i class="fas fa-house-user me-1"></i>
                      @lang('typography.agency')
                    </label>
                    <input type="text" class="form-control @error('agency') is-invalid @enderror" id="agency" name="agency" value="{{ old('agency') }}" aria-describedby="agency-feedback">
                    @error('agency')
                      <div id="agency-feedback" class="invalid-feedback">
                        {{ $errors->first('agency') }}
                      </div>
                    @enderror
                  </div>
                </div>
        
                <div class="row mb-3">
                  {{-- Person In Charge --}}
                  <div class="col col-12 col-md-6 col-lg-5 mb-3 mb-lg-0">
                    <label for="person-in-charge" class="form-label">
                      <i class="fas fa-user me-1"></i>
                      @lang('typography.person-in-charge')
                    </label>
                    <input type="text" class="form-control @error('person-in-charge') is-invalid @enderror" id="person-in-charge" name="person-in-charge" value="{{ old('person-in-charge') }}" aria-describedby="person-in-charge-feedback">
                    @error('person-in-charge')
                      <div id="person-in-charge-feedback" class="invalid-feedback">
                        {{ $errors->first('person-in-charge') }}
                      </div>
                    @enderror
                  </div>
                  {{-- Phone number --}}
                  <div class="col col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                    <label for="phone-number" class="form-label">
                      <i class="fas fa-phone me-1"></i>
                      @lang('typography.phone-number')
                    </label>
                    <input type="text" class="form-control @error('phone-number') is-invalid @enderror" id="phone-number" name="phone-number" value="{{ old('phone-number') }}" aria-describedby="phone-number-feedback">
                    @error('phone-number')
                      <div id="phone-number-feedback" class="invalid-feedback">
                        {{ $errors->first('phone-number') }}
                      </div>
                    @enderror
                  </div>
                  {{-- Member --}}
                  <div class="col col-12 col-md-6 offset-md-6 col-lg-4 offset-lg-0">
                    <div id="dynamic-member-form" class="row">
                      @php
                        $members = old('member');
                      @endphp
                      @if(isset($members) && $members->isNotEmpty())
                        @foreach($members as $member)
                          <div class="col col-12 mb-2">
                            @if($loop->iteration == 1)
                              <label for="member-1" class="form-label">
                                <i class="fas fa-users me-1"></i>
                                @lang('typography.member')
                              </label>
                            @endif
                            <input type="text" class="form-control member-field-counter @if($member['errors']->isNotEmpty()) is-invalid @endif" id="member-{{ $loop->iteration }}" name="member[]" value="{{ $member['input'] }}" aria-describedby="member-{{ $loop->iteration }}-feedback">
                            @if($member['errors']->isNotEmpty())
                              <div id="member-{{ $loop->iteration }}-feedback" class="invalid-feedback">
                                {{ $member['errors']->first() }}
                              </div>
                            @endif
                          </div>
                        @endforeach
                      @else
                        <div class="col col-12 mb-2">
                          <label for="member-1" class="form-label">
                            <i class="fas fa-users me-1"></i>
                            @lang('typography.member')
                          </label>
                          <input type="text" class="form-control member-field-counter" id="member-1" name="member[]">
                        </div>
                      @endif
                    </div>
                    <div class="row">
                      <div id="add-member-button" class="col col-12 mt-2">
                        <div class="d-grid gap-2">
                          <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-plus fa-fw"></i>
                          </button>
                        </div>
                      </div>
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
                        @php
                          $fromDate = Carbon::tomorrow()->format('Y-m-d');
                        @endphp
                        <input type="date" class="form-control @error('start-date') is-invalid @enderror" id="start-date" name="start-date" value="{{ old('start-date') ?? $fromDate }}" min="{{ $fromDate }}" aria-describedby="start-date-feedback">
                        @error('start-date')
                          <div id="start-date-feedback" class="invalid-feedback">
                            {{ $errors->first('start-date') }}
                          </div>
                        @enderror
                      </div>
                      {{-- End Date --}}
                      <div class="col col-12 col-sm-6 col-lg-12 col-xl-6">
                        <label for="end-date" class="form-label">
                          <i class="fas fa-calendar me-1"></i>
                          @lang('typography.end-date')
                        </label>
                        <input type="date" class="form-control @error('end-date') is-invalid @enderror" id="end-date" name="end-date" value="{{ old('end-date') ?? $fromDate }}" min="{{ $fromDate }}" aria-describedby="end-date-feedback">
                        @error('end-date')
                          <div id="end-date-feedback" class="invalid-feedback">
                            {{ $errors->first('end-date') }}
                          </div>
                        @enderror
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
                    <textarea class="form-control @error('goal') is-invalid @enderror" id="goal" name="goal" rows="5" aria-describedby="goal-feedback">{{ old('goal') }}</textarea>
                    @error('goal')
                      <div id="goal-feedback" class="invalid-feedback">
                        {{ $errors->first('goal') }}
                      </div>
                    @enderror
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
                        <input type="file" class="form-control @error('proposal-link') is-invalid @enderror" id="proposal-link" name="proposal-link" aria-describedby="proposal-link-feedback">
                        @error('proposal-link')
                          <div id="proposal-link-feedback" class="invalid-feedback">
                            {{ $errors->first('proposal-link') }}
                          </div>
                        @else
                          <div id="proposal-link-help" class="form-text">Format file (.pdf)</div>
                        @enderror
                      </div>
                      {{-- Cover Letter --}}
                      <div class="col col-12 col-xl-6">
                        <label for="cover-letter-link" class="form-label">
                          <i class="fas fa-file-pdf me-1"></i>
                          @lang('typography.cover-letter-file')
                        </label>
                        <input type="file" class="form-control @error('cover-letter-link') is-invalid @enderror" id="cover-letter-link" name="cover-letter-link" aria-describedby="cover-letter-link-feedback">
                        @error('cover-letter-link')
                          <div id="cover-letter-link-feedback" class="invalid-feedback">
                            {{ $errors->first('cover-letter-link') }}
                          </div>
                        @else
                          <div id="cover-letter-link-help" class="form-text">Format file (.pdf)</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Spacer --}}
                <div class="mb-3 p-1 p-md-2 p-lg-3"></div>
        
                <div class="mb-3">
                  {{-- Submit Button --}}
                  <div class="row">
                    <div class="col col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4 col-xl-2 offset-xl-5">
                      <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">@lang('action.submit')</button>
                      </div>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          @endif

        </div>
      </section>

    </div>
  </main>

  @includeWhen($ui['footer'], 'shared.footer')
@endsection

@push('script')
  <script>
    $(document).ready(function () {
      var dynamicMemberForm = $('#dynamic-member-form');

      var textFieldEl = document.querySelectorAll('.member-field-counter');
      var textFieldCount = textFieldEl.length;

      $('#add-member-button').click(function (e) { 
        e.preventDefault();
        textFieldCount++;
        var memberTextField = '<div class="col col-12 mb-2"><input type="text" class="form-control" id="member-'+textFieldCount+'" name="member[]"></div>';
        dynamicMemberForm.append(memberTextField);
      });
    });
  </script>
@endpush

@push('script')
  <script>
    $(document).ready(function () {
      var firstMemberTextField = $('#member-1');
      $('#person-in-charge').change(function (e) { 
        e.preventDefault();
        firstMemberTextField.val(e.target.value);
      });
    });
  </script>
@endpush