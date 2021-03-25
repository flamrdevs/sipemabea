<footer class="bg-primary text-light text-lg-start">
  <div class="container">
    <div class="row py-4">
      <div class="col col-12 col-lg-8 my-3">
        <div class="row">
          <div class="col col-3 col-md-2 d-flex justify-content-center">
            <img src="{{ asset('images/logo.png') }}" style="object-fit: contain; max-height: 80px;" height="100%" width="100%" alt="" loading="lazy" />
          </div>
          <div class="col col-9 col-md-10">
            <div>
              <span class="d-block font-weight-bold lh-md">DIREKTORAT JENDRAL BEA DAN CUKAI</span>
              <span class="d-block lh-sm">KANTOR WILAYAH JAWA TIMUR II</span>
              <span class="d-block lh-sm">KPPBC TIPE MADYA PABEAN C JEMBER</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col col-12 col-lg-4 my-3">
        <p class="lh-sm">Tentang Beacukai</p>
        <p class="lh-sm">Direktorat Jenderal Bea dan Cukai adalah nama dari sebuah instansi pemerintah yang melayani masyarakat di bidang kepabeanan dan cukai.</p>
        @php
          $links = Helper::getStaticJson()['links'];
          $socialMedia = $links['social-media'];
        @endphp

        @if($links['social-media']['facebook']['use'])
          <a href="{{ url($links['social-media']['facebook']['link']) }}"
          class="btn btn-secondary m-1 px-2 py-1 styled-hover-sm-swing-ver" role="button" rel="nofollow"
            target="_blank">
            <i class="fab fa-facebook-f fa-fw"></i>
          </a>
        @endif

        @if($links['social-media']['twitter']['use'])
          <a href="{{ url($links['social-media']['twitter']['link']) }}"
          class="btn btn-secondary m-1 px-2 py-1 styled-hover-sm-swing-ver" role="button" rel="nofollow"
            target="_blank">
            <i class="fab fa-twitter fa-fw"></i>
          </a>
        @endif

        @if($links['social-media']['instagram']['use'])
          <a href="{{ url($links['social-media']['instagram']['link']) }}"
          class="btn btn-secondary m-1 px-2 py-1 styled-hover-sm-swing-ver" role="button" rel="nofollow"
            target="_blank">
            <i class="fab fa-instagram fa-fw"></i>
          </a>
        @endif

        @if($links['social-media']['youtube']['use'])
          <a href="{{ url($links['social-media']['youtube']['link']) }}"
          class="btn btn-secondary m-1 px-2 py-1 styled-hover-sm-swing-ver" role="button"
            rel="nofollow" target="_blank">
            <i class="fab fa-youtube fa-fw"></i>
          </a>
        @endif

      </div>
    </div>
  </div>
  
  <div class="p-3 text-center border-top border-light" style="background-color: rgba(0, 0, 0, 0.1)">
    <span class="me-1">© <span id="copyright-year"></span> Copyright:</span>
    <a class="link-light fs-6 font-weight-bold" href="{{ route('welcome') }}">sipemabea.com</a>
  </div>
</footer>

@push('script')
  <script>
    $(document).ready(function () { var year = { release: 2021, since: new Date().getFullYear() }; if (year.since > year.release) { year.since = year.release + '-' + year.since; }; $('#copyright-year').text(year.since); });
  </script>
@endpush