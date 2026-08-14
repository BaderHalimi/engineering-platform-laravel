@extends('layouts.app')

@section('title', 'معرض الصور | الديوان للاستشارات الهندسية')


@section('description', 'معرض صور مشاريع وأعمال الديوان للاستشارات الهندسية مع نص بديل وبيانات قابلة للفهرسة لكل صورة.')
@php($seoImage = asset('logo.png'))

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
  .font-body{ font-family:var(--font-primary); }

  .section-title-underline{ width:70px; height:4px; background:linear-gradient(to left, var(--gold), var(--gold-dark)); border-radius:999px; }

  .card-hover{ transition:transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease; }
  .card-hover:hover{ transform:translateY(-6px); box-shadow:0 22px 40px -22px rgba(82,105,112,.35); border-color:rgba(245,173,42,.5); }

  .gallery-img{ transition:transform .7s cubic-bezier(.2,.8,.2,1); }
  .gallery-card:hover .gallery-img{ transform:scale(1.08); }

  .line-clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }

  .field{ width:100%; background:var(--bg-soft); border:1px solid #e5e7eb; border-radius:14px; padding:.85rem 1rem; font-size:.95rem; color:var(--teal-dark); outline:none; transition:border-color .25s ease, box-shadow .25s ease, background .25s ease; }
  .field::placeholder{ color:#9ca3af; }
  .field:focus{ border-color:var(--gold); background:#fff; box-shadow:0 0 0 4px rgba(245,173,42,.15); }

  .generic-reveal{ opacity:0; transform:translateY(24px); transition:opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
  .generic-reveal.visible{ opacity:1; transform:translateY(0); }

  .page-link{
    min-width:42px; height:42px; display:flex; align-items:center; justify-content:center;
    border-radius:12px; font-weight:700; font-size:.9rem; color:var(--teal);
    border:1px solid #e5e7eb; background:#fff; transition:all .25s ease;
  }
  .page-link:hover{ border-color:var(--gold); color:var(--gold-dark); }
  .page-link.active{
    background:linear-gradient(135deg, var(--gold), var(--gold-dark));
    color:#fff; border-color:transparent;
  }
  .page-link.disabled{ opacity:.4; pointer-events:none; }

  .stat-pill{
    display:inline-flex; align-items:center; gap:.3rem;
    font-size:.75rem; color:#fff; background:rgba(0,0,0,.45);
    padding:.3rem .65rem; border-radius:999px; backdrop-filter:blur(4px);
  }
</style>

<!-- ====== PAGE HEADER ====== -->
<section class="relative w-full py-14 md:py-20 overflow-hidden" style="background:var(--bg-soft);">
  <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px, rgba(82,105,112,.08) 1px, transparent 0); background-size:22px 22px; opacity:.5;"></div>
  <div class="absolute -top-10 -left-10 w-72 h-72 rounded-full opacity-20 blur-3xl" style="background:var(--gold);"></div>
  <div class="container mx-auto px-5 md:px-6 relative z-10 text-center max-w-2xl">
    <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
      <i class="ph-bold ph-images"></i> معرض أعمالنا
    </div>
    <h1 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">معرض الصور</h1>
    <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
    <p class="text-gray-500 text-sm md:text-lg">لمحة بصرية على مشاريعنا الهندسية والمعمارية المنجزة.</p>
  </div>
</section>

<!-- ====== SEARCH ====== -->
<section class="bg-white border-b border-gray-100">
  <div class="container mx-auto px-5 md:px-6 py-6">
    <form method="GET" action="{{ route('home_pages.images.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center gap-3 md:gap-4">
      <div class="relative flex-1">
        <i class="ph-bold ph-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="ابحث عن صورة..."
          class="field pr-11"
        >
      </div>
      <button type="submit" class="shrink-0 text-sm font-bold rounded-full px-6 py-3 flex items-center justify-center gap-2 text-white" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark));">
        <i class="ph-bold ph-magnifying-glass"></i> بحث
      </button>
      @if(request('search'))
        <a href="{{ route('home_pages.images.index') }}" class="shrink-0 text-sm font-bold rounded-full px-5 py-3 flex items-center justify-center gap-2 border border-gray-200 text-gray-500 hover:border-gray-300">
          <i class="ph-bold ph-x"></i> إلغاء
        </a>
      @endif
    </form>
  </div>
</section>

<!-- ====== GALLERY GRID ====== -->
<section class="relative py-12 md:py-20 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">

    @if($images->count())
      @php
        $imagesGridClass = $images->count() === 1
          ? 'grid grid-cols-1 gap-5 md:gap-7 max-w-xl mx-auto'
          : ($images->count() === 2
            ? 'grid grid-cols-1 sm:grid-cols-2 gap-5 md:gap-7 max-w-5xl mx-auto'
            : 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7');
      @endphp
      <div class="flex items-center justify-between mb-8 generic-reveal">
        <p class="text-gray-500 text-sm">
          عرض <span class="font-bold text-[var(--teal)]">{{ $images->count() }}</span> من
          <span class="font-bold text-[var(--teal)]">{{ $images->total() }}</span> صورة
        </p>
      </div>

      <div class="{{ $imagesGridClass }}">
        @foreach($images as $image)
          <article class="gallery-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
            <a href="{{ route('pages.image-show', $image->slug) }}" class="block relative overflow-hidden h-64">
              <img
                src="{{ $image->thumbnail_path ? Storage::url($image->thumbnail_path) : Storage::url($image->image_path) }}"
                alt="{{ $image->alt_text ?? $image->title }}"
                class="w-full h-full object-cover gallery-img"
                loading="lazy"
              >
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-transparent opacity-0 hover:opacity-100 transition-opacity"></div>

              @if($image->featured)
                <span class="absolute top-4 right-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                  <i class="ph-fill ph-star"></i> مميز
                </span>
              @endif

              <div class="absolute bottom-3 left-3 flex items-center gap-2">
                <span class="stat-pill"><i class="ph-bold ph-eye"></i> {{ number_format($image->views) }}</span>
                <span class="stat-pill"><i class="ph-bold ph-heart"></i> {{ number_format($image->likes) }}</span>
              </div>
            </a>
            <div class="p-5">
              <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug line-clamp-2">
                <a href="{{ route('pages.image-show', $image->slug) }}" class="hover:text-[var(--gold-dark)] transition">
                  {{ $image->title }}
                </a>
              </h3>
              @if($image->description)
                <p class="text-gray-500 text-xs md:text-sm mb-4 line-clamp-2">
                  {{ $image->description }}
                </p>
              @endif
              <a href="{{ route('pages.image-show', $image->slug) }}" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">
                عرض الصورة <i class="ph-bold ph-arrow-left"></i>
              </a>
            </div>
          </article>
        @endforeach
      </div>

      @if($images->hasPages())
        <div class="flex items-center justify-center gap-2 mt-12 flex-wrap">
          @if($images->onFirstPage())
            <span class="page-link disabled"><i class="ph-bold ph-caret-right"></i></span>
          @else
            <a href="{{ $images->previousPageUrl() }}" class="page-link" aria-label="Previous page"><i class="ph-bold ph-caret-right"></i><span class="sr-only">Previous page</span></a>
          @endif

          @foreach($images->getUrlRange(max(1, $images->currentPage() - 2), min($images->lastPage(), $images->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $images->currentPage() ? 'active' : '' }}">
              {{ $page }}
            </a>
          @endforeach

          @if($images->hasMorePages())
            <a href="{{ $images->nextPageUrl() }}" class="page-link" aria-label="Next page"><i class="ph-bold ph-caret-left"></i><span class="sr-only">Next page</span></a>
          @else
            <span class="page-link disabled"><i class="ph-bold ph-caret-left"></i></span>
          @endif
        </div>
      @endif

    @else
      <div class="text-center py-16 md:py-24 generic-reveal">
        <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center mb-5" style="background:rgba(245,173,42,.1);">
          <i class="ph-bold ph-images text-4xl" style="color:var(--gold-dark);"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-extrabold text-[var(--teal)] mb-2">لا توجد صور مطابقة</h3>
        <p class="text-gray-500 text-sm md:text-base mb-6">جرّب تغيير كلمات البحث الحالية.</p>
        <a href="{{ route('home_pages.images.index') }}" class="inline-flex items-center gap-2 text-sm font-bold rounded-full px-6 py-3 text-white" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark));">
          <i class="ph-bold ph-arrow-counter-clockwise"></i> عرض جميع الصور
        </a>
      </div>
    @endif

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
