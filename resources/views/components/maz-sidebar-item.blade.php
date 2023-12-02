@props(['icon', 'link', 'name'])

@php
    $routeName = Request::route()->getName();
    $newName = str_replace(' ', '', $name);
    $active = str_contains(strtolower($routeName), strtolower($newName));
    $classes = $active ? 'sidebar-item active' : 'sidebar-item';
@endphp

<li class=" {{ $classes }} {{ $slot->isEmpty() ? '' : 'has-sub' }}">
    <a href="{{ $slot->isEmpty() ? $link : '#' }}" class='sidebar-link text-white border border-light rounded'>
        <i class="{{ $icon }} text-white"></i>
        <span>{{ $name }}</span>
    </a>
    @if (!$slot->isEmpty())
        <ul class="submenu" style="display: {{ $active ? 'block' : 'none' }};">
            {{ $slot }}
        </ul>
    @endif
</li>
