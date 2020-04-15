<nav class="nav flex-column bg-white shadow-sm font-italic rounded p-3">
    @foreach($menu as $itemMenu)
        <a href="{{ $itemMenu['link'] }}"
           class="nav-link px-4 {{ $itemMenu['active'] ? 'active bg-primary text-white shadow-sm rounded-pill' : '' }}">
            {{ $itemMenu['name'] }}
        </a>
    @endforeach
</nav>