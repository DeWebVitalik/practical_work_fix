<nav class="nav flex-column bg-white shadow-sm font-italic rounded p-3">
    @foreach($menu as $itemMenu)
        <a href="{{ $itemMenu['link'] }}"
           class="nav-link px-4 {{ $itemMenu['active'] ? 'active bg-primary text-white shadow-sm rounded-pill' : '' }}">
            @if(!empty($itemMenu['icon']))
                <i class="fa fa-{{ $itemMenu['icon'] }}" aria-hidden="true"></i>
            @endif
            {{ $itemMenu['name'] }}
        </a>
    @endforeach
</nav>