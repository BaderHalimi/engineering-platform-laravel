@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'من نحن' : 'About us')

@section('content')
@php
    $locale = app()->getLocale();
    $tr = function ($field) use ($locale) {
        if (is_array($field)) {
            return $field[$locale] ?? $field['ar'] ?? (reset($field) ?: '');
        }

        return $field ?? '';
    };
@endphp

@include('partials.home.about', [
    'aboutUs' => $aboutUs,
    'siteName' => $siteName,
    'tr' => $tr,
])

@include('partials.home.why-us', [
    'whyAldiwan' => $whyAldiwan,
    'tr' => $tr,
])

@include('partials.home.process', [
    'workSteps' => $workSteps,
    'siteName' => $siteName,
    'tr' => $tr,
])
@endsection
