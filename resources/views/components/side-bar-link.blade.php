<a href="{{ $link }}" class="nav-item nav-link mb-1 {{ $link == request()->url() ? 'active':'' }}">
    <i class="fa-solid {{ $class }} me-2"></i>
    {{ $name }}
</a>
