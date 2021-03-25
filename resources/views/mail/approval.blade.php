@extends('mail.layout')

@section('body')
  <div class="bs container">

    <div class="bs text-dark">
      <div class="bs d-flex justify-content-center">

        @if($type == 'reception')
          <div class="bs flex-grow-1 bg-light m-5 p-5 rounded-3">

            <div class="bs text-dark m-1">
              <h1>Hai, {{ $name }} !</h1>
            </div>

            <div class="bs text-dark m-1">
              <p class="bs text-dark m-2">
                Selamat !!
              </p>
              <p class="bs text-dark m-2">
                Anda telah diterima Magang di Bea Cukai Jember. Kami dengan senang hati mengundang Anda untuk melaksanakan kegiatan Magang atau Praktik Kerja Lapangan di kantor kami.
              </p>

              <p class="bs text-dark m-2">
                Untuk mengonfirmasi tempat Anda di Kantor kami, silakan unduh surat tugas yang kami lampirkan dibawah ini.
              </p>

              <p class="bs text-dark m-2">
                Jika Anda telah berubah pikiran sejak mendaftar dan ingin menolak penerimaan pendaftaran ini, silakan balas email ini dengan alasan yang jelas sesegera mungkin.
              </p>

              <p class="bs text-dark m-2">
                Sekali lagi, Selamat. Kami akan menghubungi Anda mengenai program terperinci segera.
              </p>

              <p class="bs text-dark m-2">
                Salam hormat
              </p>

              <p class="bs text-dark m-2">
                Tim Bea Cukai Jember
              </p>
            </div>
            
          </div>
        @else
          <div class="bs flex-grow-1 bg-light m-5 p-5 rounded-3">

            <div class="bs text-dark m-1">
              <h1>Hai, {{ $name }} !</h1>
            </div>

            <div class="bs text-dark m-1">
              <p class="bs text-dark m-2">
                Atas nama tim Bea Cukai Jember, kami mengucapkan terima kasih atas minat dan antusiasme Anda dalam mendaftar Magang di kantor kami.
              </p>

              <p class="bs text-dark m-2">
                Sayangnya, kami ingin meminta maaf bahwa kami tidak dapat melanjutkan pendaftaran Anda karena beberapa hal yang tidak memenuhi kualifikasi kami.
              </p>

              <p class="bs text-dark m-2">
                Namun, Anda masih dapat mendaftar sebagai peserta kami lagi. kami membuka lowongan magang lagi di tanggal yang sudah tertera di surat lampiran dan anda dapat mulai mendaftarkan diri seperti langkah diawal.
              </p>

              <p class="bs text-dark m-2">
                Salam hormat
              </p>

              <p class="bs text-dark m-2">
                Tim Bea Cukai Jember
              </p>
            </div>
            
          </div>
        @endif

      </div>
    </div>

  </div>
@endsection