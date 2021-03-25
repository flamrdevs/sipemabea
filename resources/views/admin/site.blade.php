@extends('admin.layout')

@section('content')
  <div class="container my-4 p-2">

    @includeIf('shared.components.banner', [
      'title' => __('action.site'),
      'action' => ['back']
    ])

    @includeIf('shared.components.session')

    @php
      $links = $settings['links'];
      $ui = $settings['ui'];
    @endphp

    <div class="p-2 p-md-4 bg-white rounded-3 shadow-sm">
      <div class="p-2">
        <form action="{{ route('admin.site-update') }}" method="POST">
          @csrf
          
          <div class="d-grid gap-2 mb-3">
            <h2 class="text-center">@lang('typography.update-site')</h2>
          </div>

          <div class="mb-5">
            <div class="mb-3 pb-2 fs-5 fw-bold border-bottom border-primary">
              @lang('typography.links')
            </div>
            <div class="ms-3">
              <div class="mb-3">
                <label for="link-facebook" class="form-label">Facebook</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" value="true" name="use-facebook" @if($links['social-media']['facebook']['use']) checked @endif>
                  </div>
                  <input type="text" class="form-control @error('link-facebook') is-invalid @enderror" id="link-facebook" name="link-facebook" value="{{ old('link-facebook') ?? $links['social-media']['facebook']['link'] }}" aria-describedby="link-facebook-feedback">
                  @error('link-facebook')
                    <div id="link-facebook-feedback" class="invalid-feedback">
                      {{ $errors->first('link-facebook') }}
                    </div>
                  @enderror
                </div>
              </div>
    
              <div class="mb-3">
                <label for="link-twitter" class="form-label">Twitter</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" value="true" name="use-twitter" @if($links['social-media']['twitter']['use']) checked @endif>
                  </div>
                  <input type="text" class="form-control @error('link-twitter') is-invalid @enderror" id="link-twitter" name="link-twitter" value="{{ old('link-twitter') ?? $links['social-media']['twitter']['link'] }}" aria-describedby="link-twitter-feedback">
                  @error('link-twitter')
                    <div id="link-twitter-feedback" class="invalid-feedback">
                      {{ $errors->first('link-twitter') }}
                    </div>
                  @enderror
                </div>
              </div>
    
              <div class="mb-3">
                <label for="link-instagram" class="form-label">Instagram</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" value="true" name="use-instagram" @if($links['social-media']['instagram']['use']) checked @endif>
                  </div>
                  <input type="text" class="form-control @error('link-instagram') is-invalid @enderror" id="link-instagram" name="link-instagram" value="{{ old('link-instagram') ?? $links['social-media']['instagram']['link'] }}" aria-describedby="link-instagram-feedback">
                  @error('link-instagram')
                    <div id="link-instagram-feedback" class="invalid-feedback">
                      {{ $errors->first('link-instagram') }}
                    </div>
                  @enderror
                </div>
                
              </div>
    
              <div class="mb-3">
                <label for="link-youtube" class="form-label">Youtube</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" value="true" name="use-youtube" @if($links['social-media']['youtube']['use']) checked @endif>
                  </div>
                  <input type="text" class="form-control @error('link-youtube') is-invalid @enderror" id="link-youtube" name="link-youtube" value="{{ old('link-youtube') ?? $links['social-media']['youtube']['link'] }}" aria-describedby="link-youtube-feedback">
                  @error('link-youtube')
                    <div id="link-youtube-feedback" class="invalid-feedback">
                      {{ $errors->first('link-youtube') }}
                    </div>
                  @enderror
                </div>
              </div>
    
              <div class="mb-3">
                <label for="link-google-maps" class="form-label">Google Maps</label>
                <div class="input-group">
                  <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" value="true" name="use-google-maps" @if($links['google-maps']['use']) checked @endif>
                  </div>
                  <input type="text" class="form-control @error('link-google-maps') is-invalid @enderror" id="link-google-maps" name="link-google-maps" value="{{ old('link-google-maps') ?? $links['google-maps']['link'] }}" aria-describedby="link-google-maps-feedback">
                  @error('link-google-maps')
                    <div id="link-google-maps-feedback" class="invalid-feedback">
                      {{ $errors->first('link-google-maps') }}
                    </div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="mb-5">
            <div class="mb-3 pb-2 fs-5 fw-bold border-bottom border-primary">
              @lang('typography.ui-component')
            </div>
            <div class="ms-3">
              <div class="mb-2">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" value="true" id="use-header" name="use-header" @if($ui['header']) checked @endif>
                  <label class="form-check-label" for="use-header">Header</label>
                </div>
              </div>
              <div class="mb-2">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" value="true" id="use-footer" name="use-footer" @if($ui['footer']) checked @endif>
                  <label class="form-check-label" for="use-footer">Footer</label>
                </div>
              </div>
            </div>
          </div>

          <div class="my-3 p-1"></div>

          <div class="mb-1">
            <div class="row">
              <div class="col col-12 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="d-grid gap-2 d-lg-flex justify-content-lg-between">
                  <button type="submit" class="flex-lg-grow-1 btn btn-primary">@lang('action.save')</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
@endsection