@extends('layouts.app')

@section('title', $article->meta_title ?? $article->title)

@push('meta')
<meta name="description" content="{{ $article->meta_description ?? $article->excerpt }}">
@if($article->meta_keywords)
<meta name="keywords" content="{{ is_array($article->meta_keywords) ? implode(', ', $article->meta_keywords) : $article->meta_keywords }}">
@endif

<meta property="og:type" content="article">
<meta property="og:title" content="{{ $article->meta_title ?? $article->title }}">
<meta property="og:description" content="{{ $article->meta_description ?? $article->excerpt }}">
<meta property="og:image" content="{{ $article->og_image ? Storage::url($article->og_image) : ($article->thumbnail ? Storage::url($article->thumbnail) : asset('images/og-articles-cover.jpg')) }}">
<meta property="og:url" content="{{ $article->canonical_url ?? url()->current() }}">
<meta property="article:published_time" content="{{ optional($article->published_at)->toIso8601String() }}">
@if($article->category)
<meta property="article:section" content="{{ $article->category->name }}">
@endif
@if($article->tags)
@foreach($article->tags as $tag)
<meta property="article:tag" content="{{ $tag }}">
@endforeach
@endif

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $article->meta_title ?? $article->title }}">
<meta name="twitter:description" content="{{ $article->meta_description ?? $article->excerpt }}">
<meta name="twitter:image" content="{{ $article->og_image ? Storage::url($article->og_image) : ($article->thumbnail ? Storage::url($article->thumbnail) : asset('images/og-articles-cover.jpg')) }}">

<link rel="canonical" href="{{ $article->canonical_url ?? url()->current() }}">
@endpush

@section('content')
<style>
  :root{
    --teal:#526970;
    --teal-dark:#3d5258;
    --teal-light:#6b858d;
    --gold:#f5ad2a;
    --gold-dark:#d89320;
    --ink:#1E2A30;
    --line:#E7E2D8;
    --bg-soft:#fafbfc;
  }
  .font-body{ font-family:'IBM Plex Sans Arabic',sans-serif; }

  .share-btn{
    width:42px; height:42px; border-radius:14px; display:flex; align-items:center; justify-content:center;
    background:var(--bg-soft); color:var(--teal); border:1px solid #e5e7eb; transition:all .25s ease;
  }
  .share-btn:hover{ background:linear-gradient(135deg, var(--gold), var(--gold-dark)); color:#fff; border-color:transparent; transform:translateY(-2px); }

  .chip-cat{
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.5rem 1rem; border-radius:999px; font-size:.8rem; font-weight:700;
    background:linear-gradient(135deg, var(--gold), var(--gold-dark)); color:#fff;
  }

  .generic-reveal{ opacity:0; transform:translateY(24px); transition:opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
  .generic-reveal.visible{ opacity:1; transform:translateY(0); }

  .prose-article{
    font-family:'IBM Plex Sans Arabic',sans-serif;
    color:var(--teal-dark);
    font-size:1.05rem;
    line-height:2.1;
  }
  .prose-article h2{
    font-family:'Cairo','Tajawal',sans-serif;
    color:var(--teal);
    font-weight:800;
    font-size:1.6rem;
    margin-top:2.2rem;
    margin-bottom:1rem;
    padding-right:1rem;
    border-right:4px solid var(--gold);
  }
  .prose-article h3{
    font-family:'Cairo','Tajawal',sans-serif;
    color:var(--teal);
    font-weight:700;
    font-size:1.3rem;
    margin-top:1.8rem;
    margin-bottom:.8rem;
  }
  .prose-article p{ margin-bottom:1.3rem; }
  .prose-article a{ color:var(--gold-dark); font-weight:700; text-decoration:underline; }
  .prose-article ul, .prose-article ol{ margin:1.3rem 0; padding-right:1.5rem; }
  .prose-article li{ margin-bottom:.6rem; }
  .prose-article ul li::marker{ color:var(--gold); }
  .prose-article img{ border-radius:1.5rem; margin:1.8rem 0; width:100%; }
  .prose-article blockquote{
    border-right:4px solid var(--gold);
    background:var(--bg-soft);
    padding:1.2rem 1.5rem;
    border-radius:1rem;
    margin:1.8rem 0;
    font-weight:600;
    color:var(--teal);
  }
  .prose-article strong{ color:var(--teal); font-weight:800; }
  .prose-article table{ width:100%; border-collapse:collapse; margin:1.8rem 0; }
  .prose-article table th, .prose-article table td{ border:1px solid var(--line); padding:.75rem 1rem; text-align:right; }
  .prose-article table th{ background:var(--bg-soft); color:var(--teal); font-weight:700; }
  .prose-article code{ background:var(--bg-soft); padding:.2rem .5rem; border-radius:.4rem; font-size:.9em; }

  .attachment-item{
    display:flex; align-items:center; gap:.85rem;
    padding:1rem 1.2rem; border-radius:16px;
    background:var(--bg-soft); border:1px solid #e5e7eb;
    transition:all .25s ease;
  }
  .attachment-item:hover{ border-color:var(--gold); background:#fff; box-shadow:0 10px 24px -14px rgba(82,105,112,.3); }
  .attachment-icon{
    width:44px; height:44px; border-radius:12px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    background:linear-gradient(135deg, var(--teal-light), var(--teal-dark)); color:#fff; font-size:1.2rem;
  }
</style>

<!-- ====== BREADCRUMB ====== -->
<div class="bg-[var(--bg-soft)] border-b border-gray-100 py-4 mt-4">
  <div class="container mx-auto px-5 md:px-6">
    <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
      <a href="{{ route('home_pages.articles.index') }}" class="hover:text-[var(--gold-dark)] transition flex items-center gap-1">
        <i class="ph-bold ph-house-line"></i> الرئيسية
      </a>
      <i class="ph-bold ph-caret-left text-[10px]"></i>
      <a href="{{ route('home_pages.articles.index') }}" class="hover:text-[var(--gold-dark)] transition">المقالات</a>
      @if($article->category)
        <i class="ph-bold ph-caret-left text-[10px]"></i>
        <span class="text-[var(--teal)] font-semibold">{{ $article->category->name }}</span>
      @endif
    </nav>
  </div>
</div>

<!-- ====== ARTICLE HEADER ====== -->
<section class="relative py-10 md:py-16 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6 max-w-3xl">
    <div class="generic-reveal">
      <div class="flex items-center gap-3 flex-wrap mb-5">
        @if($article->category)
          <span class="chip-cat"><i class="ph-bold ph-folder"></i> {{ $article->category->name }}</span>
        @endif
        @if($article->is_trending)
          <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-full bg-red-50 text-red-500">
            <i class="ph-fill ph-flame"></i> ترند
          </span>
        @endif
      </div>

      <h1 class="text-2xl md:text-4xl font-black text-[var(--teal)] leading-snug mb-5">
        {{ $article->title }}
      </h1>

      <div class="flex items-center gap-5 flex-wrap text-sm text-gray-500 pb-6 border-b border-gray-100">
        @if($article->user)
          <span class="flex items-center gap-2 font-semibold text-[var(--teal)]">
            <i class="ph-bold ph-user-circle text-lg"></i> {{ $article->user->name }}
          </span>
        @endif
        <span class="flex items-center gap-1.5">
          <i class="ph-bold ph-calendar"></i> {{ optional($article->published_at)->translatedFormat('d F Y') }}
        </span>
        <span class="flex items-center gap-1.5">
          <i class="ph-bold ph-eye"></i> {{ number_format($article->views) }} مشاهدة
        </span>
        @if($article->reading_time)
          <span class="flex items-center gap-1.5">
            <i class="ph-bold ph-clock"></i> {{ $article->reading_time }} دقائق قراءة
          </span>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- ====== COVER IMAGE ====== -->
@if($article->thumbnail)
<section class="bg-white pb-8 md:pb-12">
  <div class="container mx-auto px-5 md:px-6 max-w-3xl generic-reveal">
    <div class="rounded-3xl overflow-hidden shadow-xl">
      <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-64 md:h-96 object-cover">
    </div>
  </div>
</section>
@endif

<!-- ====== ARTICLE CONTENT ====== -->
<section class="bg-white pb-12 md:pb-16">
  <div class="container mx-auto px-5 md:px-6 max-w-3xl">
    <div class="grid grid-cols-1 md:grid-cols-[56px_1fr] gap-6">

      <div class="hidden md:flex flex-col items-center gap-3 sticky top-24 self-start generic-reveal">
        <span class="text-[10px] font-bold text-gray-400 tracking-widest mb-1">شارك</span>
        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . ($article->canonical_url ?? url()->current())) }}" target="_blank" class="share-btn"><i class="ph-bold ph-whatsapp-logo"></i></a>
        <a href="https://twitter.com/intent/tweet?url={{ urlencode($article->canonical_url ?? url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-btn"><i class="ph-bold ph-twitter-logo"></i></a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($article->canonical_url ?? url()->current()) }}" target="_blank" class="share-btn"><i class="ph-bold ph-facebook-logo"></i></a>
        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($article->canonical_url ?? url()->current()) }}" target="_blank" class="share-btn"><i class="ph-bold ph-linkedin-logo"></i></a>
        <button onclick="navigator.clipboard.writeText('{{ $article->canonical_url ?? url()->current() }}')" class="share-btn"><i class="ph-bold ph-link-simple"></i></button>
      </div>

      <div class="prose-article generic-reveal">
        {!! $article->content !!}
      </div>
    </div>

    <div class="md:hidden flex items-center justify-center gap-3 mt-10 pt-8 border-t border-gray-100">
      <span class="text-xs font-bold text-gray-400 ml-2">شارك المقال:</span>
      <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . ($article->canonical_url ?? url()->current())) }}" target="_blank" class="share-btn"><i class="ph-bold ph-whatsapp-logo"></i></a>
      <a href="https://twitter.com/intent/tweet?url={{ urlencode($article->canonical_url ?? url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-btn"><i class="ph-bold ph-twitter-logo"></i></a>
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($article->canonical_url ?? url()->current()) }}" target="_blank" class="share-btn"><i class="ph-bold ph-facebook-logo"></i></a>
      <button onclick="navigator.clipboard.writeText('{{ $article->canonical_url ?? url()->current() }}')" class="share-btn"><i class="ph-bold ph-link-simple"></i></button>
    </div>

    @if($article->tags)
      <div class="flex items-center gap-2 flex-wrap mt-8">
        @foreach($article->tags as $tag)
          <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-[var(--bg-soft)] text-[var(--teal)] border border-gray-100">#{{ $tag }}</span>
        @endforeach
      </div>
    @endif

    @if($article->attachments && count($article->attachments))
      <div class="mt-10 pt-8 border-t border-gray-100">
        <h4 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-4 flex items-center gap-2">
          <i class="ph-bold ph-paperclip"></i> مرفقات المقال
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          @foreach($article->attachments as $attachment)
            <a href="{{ Storage::url(is_array($attachment) ? ($attachment['path'] ?? $attachment['url'] ?? '') : $attachment) }}"
               target="_blank"
               download
               class="attachment-item">
              <span class="attachment-icon"><i class="ph-bold ph-file-arrow-down"></i></span>
              <span class="text-sm font-semibold text-[var(--teal)] truncate">
                {{ is_array($attachment) ? ($attachment['name'] ?? basename($attachment['path'] ?? $attachment['url'] ?? '')) : basename($attachment) }}
              </span>
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>

<!-- ====== BACK TO ARTICLES CTA ====== -->
<section class="bg-[var(--bg-soft)] py-10 md:py-14">
  <div class="container mx-auto px-5 md:px-6 max-w-3xl text-center generic-reveal">
    <a href="{{ route('home_pages.articles.index') }}" class="inline-flex items-center gap-2 text-sm md:text-base font-bold rounded-full px-6 py-3 text-white" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark));">
      <i class="ph-bold ph-arrow-right"></i> تصفح جميع المقالات
    </a>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const els = document.querySelectorAll('.generic-reveal');
    const obs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    els.forEach(el => obs.observe(el));
  });
</script>
@endsection
