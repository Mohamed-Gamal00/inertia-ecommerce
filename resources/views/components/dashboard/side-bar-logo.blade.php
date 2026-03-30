@php
    $logoUrl = $settings && $settings->logo
        ? asset('storage/' . $settings->logo)
        : asset('assets/images/logo.jpg');
@endphp

<a href="{{route('dashboard.index')}}" class="logo logo-light">
    <span class="logo-sm">
        <img src="{{ $logoUrl }}" alt="logo" height="40" width="40">
    </span>
    <span class="logo-lg">
        <img src="{{ $logoUrl }}" alt="logo" style="object-fit: cover;" height="50" width="100%">
    </span>
</a>
