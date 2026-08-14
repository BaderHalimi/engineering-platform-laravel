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
