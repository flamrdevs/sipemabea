<div class="d-flex justify-content-between mt-1 mb-3 py-1 px-2 bg-white rounded shadow-sm">
  <div class="d-flex justify-content-start align-items-center ms-1 styled-cursor-default">
    <span class="fs-3 styled-hover-sm-swing-ver">
      @isset($title)
        {{ $title }}
      @else
        @lang('messages.no-title')
      @endisset
    </span>
  </div>
  <div class="d-flex justify-content-center align-items-center me-1">
    @isset($action)

      @if(is_array($action))
        @foreach ($action as $item)
          @if(is_array($item))
          {{-- selected action --}}
            <a class="btn btn-primary btn-sm ms-2 styled-hover-sm-swing-ver" href="{{ $item['url'] }}" role="button">
              <i class="fas fa-{{ $item['icon'] }} fa-fw mx-1"></i>
              <span>
                @lang(__($item['text']))
              </span>
            </a>
          @else
          {{-- special actions --}}
            @if($item == 'back')
              <a class="btn btn-primary btn-sm ms-2 styled-hover-sm-swing-ver" href="{{ url()->previous() }}" role="button">
                <i class="fas fa-angle-left fa-fw mx-1"></i>
                <span>@lang('action.back')</span>
              </a>
            @endif
          @endif
        @endforeach
      @endif

    @endisset
  </div>
</div>