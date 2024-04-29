@php
    $dot = $dot ?? false;
    $type = $type ?? 'primary';
    $wide = $wide ?? true;
    $rounded = $rounded ?? false;
@endphp
<span class="badge badge-{{ $type }} {{ $wide ? 'm-badge--wide' : '' }} {{ $rounded ? 'm-badge--rounded' : '' }}">
    {{ $slot }}
</span>
