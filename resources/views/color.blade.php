@extends('layouts.app')

@push('css')
  <style>
    .height {
      height: 15rem;
    }
  </style>
@endpush

@section('body')
  <div class="container">

    <div class="row">
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-primary rounded height">
          <span class="text-light fs-2 fw-bold">
            primary
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-secondary rounded height">
          <span class="text-light fs-2 fw-bold">
            secondary
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-info rounded height">
          <span class="text-light fs-2 fw-bold">
            info
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-warning rounded height">
          <span class="text-light fs-2 fw-bold">
            warning
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-danger rounded height">
          <span class="text-light fs-2 fw-bold">
            danger
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center bg-success rounded height">
          <span class="text-light fs-2 fw-bold">
            success
          </span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-100 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-100
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-200 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-200
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-300 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-300
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-400 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-400
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-500 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-500
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-600 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-600
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-700 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-700
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-800 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-800
          </span>
        </div>
      </div>
      <div class="col col-12 col-md-4 p-4">
        <div class="d-flex justify-content-center align-items-center styled-bg-gray-900 rounded height">
          <span class="text-light fs-2 fw-bold">
            styled-bg-gray-900
          </span>
        </div>
      </div>
    </div>

  </div>
@endsection