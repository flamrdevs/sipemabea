@php
  function newLineToParagraph($string) {
    $pS = '<p class="bs text-dark m-1">';
    $pE = '</p>';
    return $pS . str_replace('<br />', $pE.$pS, nl2br($string)) . $pE;
  }
@endphp

@extends('mail.layout')

@section('body')
  <div class="bs container">

    <div class="bs text-dark">
      <div class="bs d-flex justify-content-center">

        <div class="bs flex-grow-1 bg-light m-5 p-5 rounded-3">

          {!! newLineToParagraph($note) !!}
          
        </div>

      </div>
    </div>

  </div>
@endsection