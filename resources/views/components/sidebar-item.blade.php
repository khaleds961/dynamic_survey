<li class="sidebar-item {{ $isActive() ? 'selected' : '' }}">
    <a class="sidebar-link" href="{{ route($routes[0]) }}" aria-expanded="false">
        <span>
            <i class="{{ $icon }}"></i>
        </span>
        <span class="hide-menu">{{ $title }}</span>
    </a>
</li>
