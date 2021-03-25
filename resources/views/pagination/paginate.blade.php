@if($paginator->hasPages())
  <ul class="pagination">

    @if($paginator->onFirstPage())
      <li class="page-item disabled">
        <span class="page-link">
          <i class="fas fa-chevron-left fa-fw"></i>
        </span>
      </li>
    @else
      <li class="page-item">
        <a class="page-link styled-hover-sm-swing-ver" href="{{ $paginator->previousPageUrl() }}" aria-disabled="true">
          <i class="fas fa-chevron-left fa-fw"></i>
        </a>
      </li>
    @endif

    @foreach($elements as $element)
    
      @if(is_string($element))
        <li class="page-item disabled" aria-disabled="true">
          <span class="page-link px-3">{{ $element }}</span>
        </li>
      @endif

      @if(is_array($element))
        @foreach ($element as $page => $url)
          @if($page == $paginator->currentPage())
            <li class="page-item active">
              <span class="page-link px-3">{{ $page }}</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link px-3 styled-hover-sm-swing-ver" href="{{ $url }}">
                {{ $page }}
              </a>
            </li>
          @endif
        @endforeach
      @endif
    @endforeach

    @if($paginator->hasMorePages())
      <li class="page-item">
        <a class="page-link styled-hover-sm-swing-ver" href="{{ $paginator->nextPageUrl() }}" aria-disabled="true">
          <i class="fas fa-chevron-right fa-fw"></i>
        </a>
      </li>
    @else
      <li class="page-item disabled">
        <span class="page-link">
          <i class="fas fa-chevron-right fa-fw"></i>
        </span>
      </li>
    @endif

  </ul>
@endif