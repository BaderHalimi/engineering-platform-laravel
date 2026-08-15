@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'الميديا' : 'Media')

@section('description', app()->getLocale() === 'ar'
    ? 'مكتبة الميديا الخاصة بأعمال ومحتوى الديوان، وتشمل الفيديوهات ومعرض الصور.'
    : 'Al Diwan media library, including videos and image gallery.')

@section('content')
@php
    $asset = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
    $videoEmbed = function ($url) {
        if (! $url) return null;
        if (preg_match('/youtube\.com\/watch\?v=([\w\-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        if (preg_match('/youtu\.be\/([\w\-]+)/', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return $url;
    };
@endphp

<section class="relative overflow-hidden bg-white py-14 md:py-20">
  <div class="site-container text-center">
    <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
      <i class="ri-gallery-line"></i>
      {{ app()->getLocale() === 'ar' ? 'مكتبة الميديا' : 'Media Library' }}
    </div>
    <h1 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">
      {{ app()->getLocale() === 'ar' ? 'الميديا' : 'Media' }}
    </h1>
    <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
    <p class="mx-auto max-w-2xl text-sm md:text-lg text-gray-500">
      {{ app()->getLocale() === 'ar' ? 'فيديوهات وصور تعرض أعمالنا ومحتوانا الهندسي في مكان واحد.' : 'Videos and images showcasing our work and engineering content in one place.' }}
    </p>
  </div>
</section>

@include('partials.home.media', [
    'videos' => $videos,
    'images' => $images,
    'asset' => $asset,
    'videoEmbed' => $videoEmbed,
])
@endsection
