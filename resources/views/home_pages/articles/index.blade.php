@extends('layouts.app') {{-- عدّل اسم اللايوت حسب مشروعك، أو احذف هذا السطر إذا الصفحة مستقلة --}}

@section('title', 'المقالات | الديوان للاستشارات الهندسية')


@section('description', 'مقالات ونصائح هندسية ومعمارية من فريق الديوان للاستشارات الهندسية تساعد العملاء على فهم الرخص والتصميم والإشراف.')
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

  .article-img{ transition:transform .7s cubic-bezier(.2,.8,.2,1); }
  .article-card:hover .article-img{ transform:scale(1.08); }

  .line-clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .line-clamp-1{ display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }

  .field{ width:100%; background:var(--bg-soft); border:1px solid #e5e7eb; border-radius:14px; padding:.85rem 1rem; font-size:.95rem; color:var(--teal-dark); outline:none; transition:border-color .25s ease, box-shadow .25s ease, background .25s ease; }
  .field::placeholder{ color:#9ca3af; }
  .field:focus{ border-color:var(--gold); background:#fff; box-shadow:0 0 0 4px rgba(245,173,42,.15); }

  .chip{
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.55rem 1.1rem; border-radius:999px; font-size:.85rem; font-weight:700;
    border:1px solid #e5e7eb; color:var(--teal); background:#fff;
    transition:all .25s ease; white-space:nowrap;
  }
  .chip:hover{ border-color:var(--gold); color:var(--gold-dark); }
  .chip.active{
    background:linear-gradient(135deg, var(--gold), var(--gold-dark));
    color:#fff; border-color:transparent;
    box-shadow:0 8px 18px -8px rgba(245,173,42,.55);
  }

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
</style>

<!-- ====== PAGE HEADER ====== -->
<section class="relative w-full py-14 md:py-20 overflow-hidden" style="background:var(--bg-soft);">
  <div class="absolute inset-0" style="background-image:radial-gradient(circle at 1px 1px, rgba(82,105,112,.08) 1px, transparent 0); background-size:22px 22px; opacity:.5;"></div>
  <div class="absolute -top-10 -left-10 w-72 h-72 rounded-full opacity-20 blur-3xl" style="background:var(--gold);"></div>
  <div class="container mx-auto px-5 md:px-6 relative z-10 text-center max-w-2xl">
    <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-4">
      <i class="ph-bold ph-newspaper"></i> مدوّنتنا الهندسية
    </div>
    <h1 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-3 md:mb-4">جميع المقالات</h1>
    <div class="section-title-underline mx-auto mb-4 md:mb-5"></div>
    <p class="text-gray-500 text-sm md:text-lg">مقالات ونصائح معمارية تساعدك على فهم مشروعك واتخاذ قرارات أفضل.</p>
  </div>
</section>

<!-- ====== SEARCH + FILTER ====== -->
<section class="bg-white border-b border-gray-100">
  <div class="container mx-auto px-5 md:px-6 py-6">
    <form method="GET" action="{{ route('home_pages.articles.index') }}" class="flex flex-col md:flex-row items-stretch md:items-center gap-3 md:gap-4">
      <div class="relative flex-1">
        <i class="ph-bold ph-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="ابحث عن مقال..."
          class="field pr-11"
        >
      </div>
      <button type="submit" class="shrink-0 text-sm font-bold rounded-full px-6 py-3 flex items-center justify-center gap-2 text-white" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark));">
        <i class="ph-bold ph-magnifying-glass"></i> بحث
      </button>
      @if(request('search') || request('category'))
        <a href="{{ route('home_pages.articles.index') }}" class="shrink-0 text-sm font-bold rounded-full px-5 py-3 flex items-center justify-center gap-2 border border-gray-200 text-gray-500 hover:border-gray-300">
          <i class="ph-bold ph-x"></i> إلغاء
        </a>
      @endif
      @if(request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif
    </form>

    @php
      $availableCategories = $articles->getCollection()->pluck('category')->filter()->unique('id')->values();
    @endphp
    @if($availableCategories->count())
      <div class="flex items-center gap-2 overflow-x-auto mt-4 pb-1" style="scrollbar-width:none;">
        <a href="{{ route('home_pages.articles.index', array_filter(['search' => request('search')])) }}"
           class="chip {{ request('category') ? '' : 'active' }}">
          <i class="ph-bold ph-squares-four"></i> الكل
        </a>
        @foreach($availableCategories as $cat)
          <a href="{{ route('home_pages.articles.index', array_filter(['search' => request('search'), 'category' => $cat->slug ?? $cat->id])) }}"
             class="chip {{ request('category') == ($cat->slug ?? $cat->id) ? 'active' : '' }}">
            {{ $cat->name }}
          </a>
        @endforeach
      </div>
    @endif
  </div>
</section>

<!-- ====== ARTICLES GRID ====== -->
<section class="relative py-12 md:py-20 bg-white overflow-hidden">
  <div class="container mx-auto px-5 md:px-6">

    @if($articles->count())
      @php
        $articlesGridClass = $articles->count() === 1
          ? 'grid grid-cols-1 gap-5 md:gap-7 max-w-xl mx-auto'
          : ($articles->count() === 2
            ? 'grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-7 max-w-5xl mx-auto'
            : 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-7');
      @endphp
      <div class="flex items-center justify-between mb-8 generic-reveal">
        <p class="text-gray-500 text-sm">
          عرض <span class="font-bold text-[var(--teal)]">{{ $articles->count() }}</span> من
          <span class="font-bold text-[var(--teal)]">{{ $articles->total() }}</span> مقال
        </p>
      </div>

      <div class="{{ $articlesGridClass }}">
        @foreach($articles as $article)
          <article class="article-card card-hover bg-white rounded-3xl overflow-hidden border border-gray-100 generic-reveal">
            <a href="{{ route('home_pages.articles.view', $article->slug) }}" class="block relative overflow-hidden h-52">
              <img
                src="{{ $article->thumbnail ? Storage::url($article->thumbnail) : asset('logo.png') }}"
                alt="{{ $article->title }}"
                class="w-full h-full object-cover article-img"
                loading="lazy"
              >
              @if($article->category)
                <span class="absolute top-4 right-4 bg-[var(--teal)] text-white text-xs font-bold px-3 py-1.5 rounded-full">
                  {{ $article->category->name }}
                </span>
              @endif
              @if($article->is_featured)
                <span class="absolute top-4 left-4 bg-[var(--gold)] text-white text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                  <i class="ph-fill ph-star"></i> مميز
                </span>
              @endif
            </a>
            <div class="p-5 md:p-6">
              <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                <span class="flex items-center gap-1">
                  <i class="ph-bold ph-calendar"></i>
                  {{ optional($article->published_at)->translatedFormat('d F Y') }}
                </span>
                <span class="flex items-center gap-1">
                  <i class="ph-bold ph-eye"></i> {{ number_format($article->views) }}
                </span>
                @if($article->reading_time)
                  <span class="flex items-center gap-1">
                    <i class="ph-bold ph-clock"></i> {{ $article->reading_time }} د
                  </span>
                @endif
              </div>
              <h3 class="font-extrabold text-[var(--teal)] text-base md:text-lg mb-2 leading-snug line-clamp-2">
                <a href="{{ route('home_pages.articles.view', $article->slug) }}" class="hover:text-[var(--gold-dark)] transition">
                  {{ $article->title }}
                </a>
              </h3>
              <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-5 line-clamp-2">
                {{ $article->excerpt }}
              </p>
              <a href="{{ route('home_pages.articles.view', $article->slug) }}" class="inline-flex items-center gap-1 text-[var(--gold-dark)] font-bold text-sm hover:gap-3 transition-all">
                اقرأ المقال <i class="ph-bold ph-arrow-left"></i>
              </a>
            </div>
          </article>
        @endforeach
      </div>

      @if($articles->hasPages())
        <div class="flex items-center justify-center gap-2 mt-12 flex-wrap">
          @if($articles->onFirstPage())
            <span class="page-link disabled"><i class="ph-bold ph-caret-right"></i></span>
          @else
            <a href="{{ $articles->previousPageUrl() }}" class="page-link" aria-label="Previous page"><i class="ph-bold ph-caret-right"></i><span class="sr-only">Previous page</span></a>
          @endif

          @foreach($articles->getUrlRange(max(1, $articles->currentPage() - 2), min($articles->lastPage(), $articles->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="page-link {{ $page == $articles->currentPage() ? 'active' : '' }}">
              {{ $page }}
            </a>
          @endforeach

          @if($articles->hasMorePages())
            <a href="{{ $articles->nextPageUrl() }}" class="page-link" aria-label="Next page"><i class="ph-bold ph-caret-left"></i><span class="sr-only">Next page</span></a>
          @else
            <span class="page-link disabled"><i class="ph-bold ph-caret-left"></i></span>
          @endif
        </div>
      @endif

    @else
      <div class="text-center py-16 md:py-24 generic-reveal">
        <div class="w-20 h-20 mx-auto rounded-3xl flex items-center justify-center mb-5" style="background:rgba(245,173,42,.1);">
          <i class="ph-bold ph-newspaper text-4xl" style="color:var(--gold-dark);"></i>
        </div>
        <h3 class="text-xl md:text-2xl font-extrabold text-[var(--teal)] mb-2">لا توجد مقالات مطابقة</h3>
        <p class="text-gray-500 text-sm md:text-base mb-6">جرّب تغيير كلمات البحث أو إزالة الفلترة الحالية.</p>
        <a href="{{ route('home_pages.articles.index') }}" class="inline-flex items-center gap-2 text-sm font-bold rounded-full px-6 py-3 text-white" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark));">
          <i class="ph-bold ph-arrow-counter-clockwise"></i> عرض جميع المقالات
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
