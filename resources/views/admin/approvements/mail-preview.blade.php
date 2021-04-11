@php
  function newLineToParagraph($string) {
    $pS = '<p class="text-dark m-1">';
    $pE = '</p>';
    return $pS . str_replace('<br />', $pE.$pS, nl2br($string)) . $pE;
  }
@endphp

@extends('admin.layout')

@section('content')
  <div class="container my-4 p-1 p-md-2">

    @includeIf('shared.components.banner', [
      'title' => __('action.submissions'),
      'action' => ['back'],
    ])

    <div class="p-2 p-md-4 bg-white rounded-3 shadow-sm">
      <div class="p-2">

        <form action="{{ route('admin.approvements.mail_send', ['id' => $submission['id']]) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="d-grid gap-2 mb-3">
            <h2 class="text-center">@lang('typography.preview-email')</h2>
          </div>

          

          <div class="text-dark">
            <div class="d-flex justify-content-center">
      
              <div class="flex-grow-1 bg-light m-5 p-5 rounded-3">
      
                {!! newLineToParagraph($text) !!}
                
              </div>
      
            </div>
          </div>

          {{-- Spacer --}}
          <div class="mb-3 p-1 p-md-2 p-lg-3"></div>

          <div class="mb-1">
            {{-- Submit Button --}}
            <div class="row">
              <div class="col col-12 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-between">
                  <button type="submit" class="flex-lg-grow-1 btn btn-primary">@lang('action.send')</button>
                </div>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>

  </div>
@endsection