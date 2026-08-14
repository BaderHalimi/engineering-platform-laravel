{{-- resources/views/home_pages/projects/index.blade.php --}}
@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'مشاريعنا' : 'Our Projects')

@section('description', app()->getLocale() === 'ar' ? 'نماذج مشاريع وأعمال هندسية منشورة مع تصنيف وبحث وروابط تفاصيل قابلة للفهرسة.' : 'Published engineering project portfolio with filtering, search, and indexable detail pages.')

@push('styles')
<style>
    .projects-hero {
        text-align: center;
        padding: 44px 0 12px;
        position: relative;
    }
    .projects-hero .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        color: var(--gold);
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .projects-hero .eyebrow::before,
    .projects-hero .eyebrow::after {
        content: "";
        width: 24px;
        height: 1px;
        background: var(--gold);
    }
    .projects-hero h1 {
        font-family: var(--font-display);
        font-weight: 800;
        font-size: 34px;
        color: var(--ink);
        margin: 0 0 8px;
    }
    .projects-hero p { color: var(--slate); font-size: 14px; margin: 0; }
    .projects-hero p strong { color: var(--teal); font-weight: 700; }

    .filters-bar {
        display: flex;
        gap: 10px;
        max-width: 720px;
        margin: 28px auto 32px;
        flex-wrap: wrap;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        padding: 10px;
        box-shadow: 0 10px 30px -14px rgba(34,38,43,.12);
    }
    .filters-bar .field-wrap {
        position: relative;
        flex: 1;
        min-width: 200px;
    }
    .filters-bar .field-wrap i {
        position: absolute;
        inset-inline-start: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #A5A099;
        font-size: 15px;
        pointer-events: none;
    }
    .filters-bar input,
    .filters-bar select {
        width: 100%;
        border: 1px solid transparent;
        background: var(--paper);
        border-radius: 999px;
        padding: 12px 18px 12px 40px;
        font-family: var(--font-body);
        font-size: 14px;
        outline: none;
        transition: border-color .2s ease, background .2s ease;
    }
    [dir="rtl"] .filters-bar input,
    [dir="rtl"] .filters-bar select { padding: 12px 40px 12px 18px; }
    .filters-bar input:focus,
    .filters-bar select:focus { border-color: var(--teal); background: #fff; }
    .filters-bar select { padding-inline-start: 40px; cursor: pointer; }
    .filters-bar button {
        display: flex;
        align-items: center;
        gap: 6px;
        background: var(--teal);
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 0 26px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: background .2s ease, transform .15s ease;
    }
    .filters-bar button:hover { background: var(--teal-dark); transform: translateY(-1px); }

    .results-info {
        font-size: 13px;
        color: var(--slate);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
    }
    .results-info strong { color: var(--teal); }
    .results-info a.clear {
        color: var(--gold);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: color .2s ease;
    }
    .results-info a.clear:hover { color: var(--teal-dark); }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }
    @media (max-width: 960px) { .projects-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .projects-grid { grid-template-columns: 1fr; } }

    .project-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 18px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        position: relative;
    }
    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -14px rgba(34,38,43,.2);
        border-color: var(--teal);
    }
    .thumb-wrap {
        position: relative;
        width: 100%;
        padding-top: 66%;
        background: var(--paper);
        overflow: hidden;
    }
    .thumb-wrap img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .project-card:hover .thumb-wrap img { transform: scale(1.06); }
    .thumb-wrap::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(34,38,43,.35), transparent 50%);
        opacity: 0;
        transition: opacity .25s ease;
    }
    .project-card:hover .thumb-wrap::after { opacity: 1; }
    .category-badge {
        position: absolute;
        top: 12px;
        inset-inline-start: 12px;
        background: var(--gold);
        color: #22262B;
        font-size: 11px;
        font-weight: 800;
        padding: 5px 13px;
        border-radius: 999px;
        letter-spacing: .2px;
        z-index: 1;
    }
    .card-body { padding: 18px; position: relative; }
    .card-body h3 {
        font-family: var(--font-display);
        font-weight: 700;
        font-size: 16px;
        color: var(--ink);
        margin: 0;
        transition: color .2s ease;
    }
    .project-card:hover .card-body h3 { color: var(--teal-dark); }
    .card-body .arrow {
        position: absolute;
        top: 18px;
        inset-inline-end: 18px;
        color: var(--gold);
        opacity: 0;
        transform: translateX(-6px);
        transition: all .25s ease;
    }
    [dir="rtl"] .card-body .arrow { transform: translateX(6px); }
    .project-card:hover .card-body .arrow { opacity: 1; transform: translateX(0); }

    .empty-state {
        text-align: center;
        padding: 70px 20px;
        color: var(--slate);
        background: #fff;
        border: 1px dashed var(--line);
        border-radius: 20px;
        margin-bottom: 40px;
    }
    .empty-state i { font-size: 46px; color: var(--gold-soft); margin-bottom: 14px; display: block; }
    .empty-state p { margin: 0 0 6px; font-weight: 600; color: var(--ink); }

    .pagination-wrap { display: flex; justify-content: center; margin-bottom: 48px; }
    .pagination-wrap nav > div > span,
    .pagination-wrap nav { font-family: var(--font-body); }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4">

    <div class="projects-hero">
        <span class="eyebrow">{{ app()->getLocale() === 'ar' ? 'أعمالنا' : 'Our Work' }}</span>
        <h1>{{ app()->getLocale() === 'ar' ? 'مشاريعنا' : 'Our Projects' }}</h1>
        <p><strong>{{ $projects->total() }}</strong> {{ app()->getLocale() === 'ar' ? 'مشروع منجز' : 'completed projects' }}</p>
    </div>

    <form method="GET" action="{{ route('home_pages.projects.index') }}" class="filters-bar">
        <div class="field-wrap">
            <i class="ri-search-line"></i>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث باسم المشروع...' : 'Search by project name...' }}"
            >
        </div>

        <div class="field-wrap" style="flex:0 0 auto; min-width:180px;">
            <i class="ri-price-tag-3-line"></i>
            <select name="category">
                <option value="">{{ app()->getLocale() === 'ar' ? 'كل التصنيفات' : 'All categories' }}</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">
            <i class="ri-search-line"></i>
            {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
        </button>
    </form>

    @if(request('search') || request('category'))
        <div class="results-info">
            {{ app()->getLocale() === 'ar' ? 'النتائج' : 'Results' }}: <strong>{{ $projects->total() }}</strong>
            <a href="{{ route('home_pages.projects.index') }}" class="clear">
                <i class="ri-close-circle-line"></i> {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر' : 'Clear filters' }}
            </a>
        </div>
    @endif

    @if($projects->count())
        <div class="projects-grid">
            @foreach($projects as $project)
                <a href="{{ route('home_pages.projects.view', $project->slug) }}" class="project-card">
                    <div class="thumb-wrap">
                        @if($project->image)
                            <img src="{{ asset('storage/' . ltrim($project->image, '/')) }}" alt="{{ $project->title }}" loading="lazy">
                        @endif
                        @if($project->category)
                            <span class="category-badge">{{ $project->category->name }}</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3>{{ $project->title }}</h3>
                        <i class="ri-arrow-left-line arrow"></i>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $projects->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="ri-folder-open-line"></i>
            <p>{{ app()->getLocale() === 'ar' ? 'لا توجد مشاريع مطابقة' : 'No projects found' }}</p>
            @if(request('search') || request('category'))
                <a href="{{ route('home_pages.projects.index') }}" class="clear" style="color: var(--gold); text-decoration:none; font-weight:600;">
                    {{ app()->getLocale() === 'ar' ? 'مسح الفلاتر وعرض الكل' : 'Clear filters and view all' }}
                </a>
            @endif
        </div>
    @endif

</div>
@endsection
