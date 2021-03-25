@extends('mail.layout')

@section('body')
  <div class="bs container">

    <div class="bs text-dark">
      <div class="bs d-flex justify-content-center">
        <div class="bs flex-grow-1 bg-light m-5 p-5 rounded-3">

          <div class="bs text-dark m-1">
            Lupa password
          </div>

          <div class="bs text-dark m-1">
            <p class="bs text-dark m-2">
              Tekan tombol dibawah untuk pengaturan ulang kata sandi anda
            </p>
            <p class="bs text-dark m-2 p-3">
              <a class="bs bg-primary text-light p-3 rounded" href="{{ route('reset_password', ['email' => $email, 'token' => base64_encode($token)]) }}">
                Atur ulang kata sandi
              </a>
            </p>
          </div>
          
        </div>
      </div>
    </div>

  </div>
@endsection