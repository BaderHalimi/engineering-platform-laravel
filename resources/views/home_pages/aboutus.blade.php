@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'من نحن' : 'About us')

@section('description', app()->getLocale() === 'ar' ? 'تعرف على الديوان للاستشارات الهندسية وخبرتها ومنهجية العمل والقيمة التي تقدمها للعملاء.' : 'Learn about Al Diwan Engineering Consulting, its experience, working approach, and client value.')

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

<section class="relative py-12 md:py-16 bg-white text-center">
    <div class="site-container">
        <p class="mb-3 text-sm font-bold text-[var(--gold-dark)]">{{ app()->getLocale() === 'ar' ? 'من نحن' : 'About us' }}</p>
        <h1 class="text-3xl md:text-5xl font-black text-[var(--teal)]">{{ app()->getLocale() === 'ar' ? 'الديوان للاستشارات الهندسية' : 'Al Diwan Engineering Consulting' }}</h1>
    </div>
</section>

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
