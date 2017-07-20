@if ($paginator->lastPage() > 1)
<ul class="ui pagination menu">
    <a href="{{ $paginator->url(1) }}" class="item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">«</a>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
      <a href="{{ $paginator->url($i) }}" class="item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">{{ $i }}</a>
    @endfor
    <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">»</a>
</ul>
@endif
