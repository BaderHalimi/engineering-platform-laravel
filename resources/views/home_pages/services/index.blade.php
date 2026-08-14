@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'الخدمات' : 'Services')

@section('content')
@php
    $locale = app()->getLocale();
    $tr = function ($field) use ($locale) {
        if (is_array($field)) {
            return $field[$locale] ?? $field['ar'] ?? (reset($field) ?: '');
        }

        return $field ?? '';
    };
    $asset = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
@endphp

<div class="pt-8">
    @include('partials.home.services', [
        'services' => $services,
        'tr' => $tr,
        'asset' => $asset,
        'contactUrl' => route('home') . '#contact',
    ])
</div>
@endsection
