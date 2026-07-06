@extends('layouts.app')

@section('title', __('videos.library'))

@push('meta')
    <meta name="description" content="{{ __('videos.library') }}">
@endpush

@push('styles')
<style>
    .page-header {
        text-align: center;
        padding: 32px 0 8px;
    }
    .page-header h1 {
        font-family: 'Cairo', sans-serif;
        font-weight: 800;
        font-size: 30px;
        color: #22262B;
        margin: 0 0 6px;
    }
    .page-header p { color: #5B6067; font-size: 14px; margin: 0; }

    .ad-slot {
        background: repeating-linear-gradient(45deg, #F1F0EC, #F1F0EC 10px, #EAE8E2 10px, #EAE8E2 20px);
        border: 1px dashed #C9C6BD;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9A968C;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .5px;
        text-transform: uppercase;
    }
    .ad-slot i { margin-inline-end: 6px; }
    .ad-leaderboard { width: 100%; max-width: 728px; height: 90px; margin: 20px auto; }

    /* Search bar */
    .search-bar {
        display: flex;
        gap: 10px;
        max-width: 560px;
        margin: 20px auto 30px;
    }
    .search-bar input {
        flex: 1;
        border: 1px solid #E6E3DC;
        border-radius: 999px;
        padding: 12px 20px;
        font-family: 'IBM Plex Sans Arabic', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color .2s ease;
    }
    .search-bar input:focus { border-color: #3D526B; }
    .search-bar button {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #3D526B;
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 0 22px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: background .2s ease;
    }
    .search-bar button:hover { background: #324259; }

    .results-info {
        font-size: 13px;
        color: #5B6067;
        margin-bottom: 16px;
    }
    .results-info strong { color: #3D526B; }
    .results-info a.clear {
        color: #C89B3C;
        font-weight: 600;
        margin-inline-start: 8px;
        text-decoration: none;
    }

    /* Grid */
    .videos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }
    @media (max-width: 960px) { .videos-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .videos-grid { grid-template-columns: 1fr; } }

    .video-card {
        background: #fff;
        border: 1px solid #E6E3DC;
        border-radius: 16px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(34,38,43,.15);
    }
    .thumb-wrap {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        background: #EDEBE5;
        overflow: hidden;
    }
    .thumb-wrap img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .play-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(34,38,43,.15);
        transition: background .2s ease;
    }
    .video-card:hover .play-overlay { background: rgba(34,38,43,.35); }
    .play-overlay i {
        font-size: 42px;
        color: #fff;
        filter: drop-shadow(0 2px 6px rgba(0,0,0,.4));
    }
    .duration-badge {
        position: absolute;
        bottom: 8px;
        inset-inline-end: 8px;
        background: rgba(34,38,43,.85);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .featured-badge-sm {
        position: absolute;
        top: 8px;
        inset-inline-start: 8px;
        background: #C89B3C;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .card-body { padding: 16px; }
    .card-body h3 {
        font-family: 'Cairo', sans-serif;
        font-weight: 700;
        font-size: 15px;
        color: #22262B;
        margin: 0 0 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .card-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 12px;
        color: #5B6067;
    }
    .card-meta span { display: flex; align-items: center; gap: 4px; }
    .card-meta i { color: #3D526B; font-size: 14px; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #5B6067;
    }
    .empty-state i { font-size: 48px; color: #C9C6BD; margin-bottom: 12px; display: block; }

    /* Pagination */
    .pagination-wrap { display: flex; justify-content: center; margin-bottom: 40px; }
    .pagination-wrap nav > div { display: flex; justify-content: center; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4">

    <div class="page-header">
        <h1>{{ __('videos.library') }}</h1>
        <p>{{ $videos->total() }} {{ __('videos.views') === 'views' ? 'videos' : 'فيديو' }}</p>
    </div>

    <div class="ad-slot ad-leaderboard">
        <i class="ri-megaphone-line"></i> {{ __('videos.ad_label') }} 728×90
    </div>

    <form method="GET" action="{{ route('home_pages.videos.index') }}" class="search-bar">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="{{ app()->getLocale() === 'ar' ? 'ابحث عن فيديو...' : 'Search videos...' }}"
        >
        <button type="submit">
            <i class="ri-search-line"></i>
            {{ app()->getLocale() === 'ar' ? 'بحث' : 'Search' }}
        </button>
    </form>

    @if(request('search'))
        <div class="results-info">
            {{ app()->getLocale() === 'ar' ? 'نتائج البحث عن' : 'Results for' }}:
            <strong>"{{ request('search') }}"</strong>
            ({{ $videos->total() }})
            <a href="{{ route('home_pages.videos.index') }}" class="clear">
                <i class="ri-close-circle-line"></i> {{ app()->getLocale() === 'ar' ? 'مسح' : 'Clear' }}
            </a>
        </div>
    @endif

    @if($videos->count())
        <div class="videos-grid">
            @foreach($videos as $video)
                <a href="{{ route('home_pages.videos.view', $video->slug) }}" class="video-card">
                    <div class="thumb-wrap">
                        @if($video->thumbnail)
                            <img src="{{ Storage::disk('public')->url($video->thumbnail) }}" alt="{{ $video->title }}">
                        @endif
                        <div class="play-overlay"><i class="ri-play-circle-fill"></i></div>

                        @if($video->is_featured)
                            <span class="featured-badge-sm"><i class="ri-star-fill"></i> Featured</span>
                        @endif

                        @if($video->duration)
                            <span class="duration-badge">{{ gmdate('i:s', $video->duration) }}</span>
                        @endif
                    </div>

                    <div class="card-body">
                        <h3>{{ $video->title }}</h3>
                        <div class="card-meta">
                            <span><i class="ri-eye-line"></i> {{ $video->views }}</span>
                            <span><i class="ri-thumb-up-line"></i> {{ $video->likes }}</span>
                            @if($video->published_at)
                                <span><i class="ri-calendar-line"></i> {{ $video->published_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrap">
            {{ $videos->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="ri-video-off-line"></i>
            {{ app()->getLocale() === 'ar' ? 'لا توجد نتائج مطابقة' : 'No videos found' }}
        </div>
    @endif

</div>
@endsection
