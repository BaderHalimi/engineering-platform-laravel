@extends('layouts.app')

@section('title', $video->seo_title ?: $video->title)
@section('description', $video->seo_description ?: $video->description)
@php
    $seoCanonical = $video->canonical_url ?: url()->current();
    $seoImage = \App\Support\Seo::imageUrl($video->og_image ?: $video->thumbnail);
    $seoType = 'video.other';
    $seoSchema = [
        \App\Support\Seo::video($video),
        \App\Support\Seo::breadcrumb([
            ['name' => app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home', 'url' => route('home')],
            ['name' => __('videos.library'), 'url' => route('home_pages.videos.index')],
            ['name' => $video->title, 'url' => $seoCanonical],
        ]),
    ];
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">

<style>
    .video-wrapper {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* 16:9 */
        background: #000;
        border-radius: 16px;
        overflow: hidden;
    }
    .video-wrapper iframe,
    .video-wrapper video {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
.video-wrapper {
    position: relative;
    width: 100%;
    padding-top: 56.25%;
    background: #000;
    border-radius: 16px;
    overflow: hidden;
}

.video-wrapper iframe,
.video-wrapper video,
.video-wrapper embed,
.video-wrapper object {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    inset: 0 !important;
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
    border: 0 !important;
}
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
    .ad-leaderboard { width: 100%; max-width: 728px; height: 90px; margin: 24px auto; }
    .ad-rectangle { width: 100%; height: 250px; margin-bottom: 20px; }

    .breadcrumb {
        font-size: 13px;
        color: #5B6067;
        margin: 20px 0 8px;
    }
    .breadcrumb a { color: #3D526B; font-weight: 600; text-decoration: none; }
    .breadcrumb i { font-size: 12px; margin: 0 4px; vertical-align: middle; }

    .layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
        padding: 12px 0 60px;
        align-items: start;
    }
    @media (max-width: 860px) { .layout { grid-template-columns: 1fr; } }

    .main-card {
        background: #fff;
        border: 1px solid #E6E3DC;
        border-radius: 16px;
        overflow: hidden;
    }
    .content-pad { padding: 28px; }

    .title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }
    .title-row h1 {
        font-family:var(--font-primary);
        font-weight: 800;
        font-size: 26px;
        color: #22262B;
        margin: 0;
    }
    .byline { font-size: 13px; color: #5B6067; margin-top: 6px; }
    .byline i { color: #3D526B; margin-inline-end: 4px; }

    .featured-badge {
        background: #C89B3C;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .stats-strip {
        display: flex;
        background: rgba(61, 82, 107, 0.35);
        border-radius: 10px;
        margin: 20px 0;
        overflow: hidden;
    }
    .stat {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 8px;
        border-inline-end: 1px dashed rgba(61,82,107,.3);
        font-size: 14px;
        font-weight: 600;
        color: #3D526B;
    }
    .stat:last-child { border-inline-end: none; }
    .stat i { font-size: 18px; }
    .stat span.num { font-family:var(--font-primary); font-weight: 800; color: #22262B; }

    .actions { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 22px; }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 14px;
        border: 1px solid #E6E3DC;
        background: #fff;
        color: #22262B;
        cursor: pointer;
        transition: all .2s ease;
        text-decoration: none;
    }
    .btn i { font-size: 17px; }
    .btn:hover { border-color: #3D526B; color: #3D526B; }
    .btn.primary { background: #3D526B; color: #fff; border-color: #3D526B; }
    .btn.primary:hover { background: #324259; color: #fff; }
    .btn.liked { background: #C89B3C; border-color: #C89B3C; color: #fff; }
    .btn.disliked { background: #8A8580; border-color: #8A8580; color: #fff; }
    .btn:disabled { opacity: .7; cursor: not-allowed; }

    .description {
        border-top: 1px solid #E6E3DC;
        padding-top: 20px;
        font-size: 15px;
        color: #22262B;
    }
    .description h3 {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #5B6067;
        margin-bottom: 10px;
    }
    .description :is(h1,h2,h3,h4) { font-family:var(--font-primary); margin: 16px 0 8px; }
    .description p { margin: 0 0 12px; }

    .sidebar-card {
        background: #fff;
        border: 1px solid #E6E3DC;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .sidebar-card h4 {
        font-size: 13px;
        text-transform: uppercase;
        color: #5B6067;
        margin-bottom: 12px;
        letter-spacing: .5px;
    }
    .mini-stat {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #E6E3DC;
        font-size: 14px;
    }
    .mini-stat:last-child { border-bottom: none; }
    .mini-stat i { color: #3D526B; margin-inline-end: 6px; }

    .toast {
        position: fixed;
        bottom: 24px;
        inset-inline-start: 50%;
        transform: translateX(-50%);
        background: #22262B;
        color: #fff;
        padding: 10px 20px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
        z-index: 100;
    }
    [dir="rtl"] .toast { transform: translateX(50%); }
    .toast.show { opacity: 1; }
</style>
@endpush
@section('content')
<div class="container mx-auto px-4">
    <div class="ad-slot ad-leaderboard">
        <i class="ri-megaphone-line"></i> {{ __('videos.ad_label') }} 728×90
    </div>

    <div class="breadcrumb">
        <a href="{{ route('home_pages.videos.index') }}">{{ __('videos.home') }}</a>
        <i class="ri-arrow-left-s-line"></i>
        <a href="{{ route('home_pages.videos.index') }}">{{ __('videos.library') }}</a>
        <i class="ri-arrow-left-s-line"></i>
        {{ $video->title }}
    </div>

    <div class="layout">

        <!-- Main content -->
        <div>
            <div class="main-card">
<div class="video-wrapper">
    @if($video->video_path)
        <video id="player" playsinline controls
               poster="{{ $video->thumbnail ? Storage::disk('public')->url($video->thumbnail) : '' }}">
            <source src="{{ Storage::disk('public')->url($video->video_url) }}" type="video/mp4">
        </video>
    @elseif($video->embed)
        {!! $video->embed !!}
    @endif
</div>

                <div class="content-pad">
                    <div class="title-row">
                        <div>
                            <h1>{{ $video->title }}</h1>
                            <div class="byline">
                                @if($video->user)
                                    <i class="ri-user-3-line"></i>{{ __('videos.by') }} {{ $video->user->name }}
                                @endif
                                @if($video->duration)
                                    <span style="margin-inline-start:10px">
                                        <i class="ri-time-line"></i>
                                        {{ gmdate('i:s', $video->duration) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if($video->is_featured)
                            <span class="featured-badge"><i class="ri-star-fill"></i> Featured</span>
                        @endif
                    </div>

                    <div class="stats-strip">
                        <div class="stat"><i class="ri-eye-line"></i> <span class="num" id="views-count">{{ $video->views }}</span></div>
                        <div class="stat"><i class="ri-thumb-up-line"></i> <span class="num" id="likes-count">{{ $video->likes }}</span></div>
                        <div class="stat"><i class="ri-thumb-down-line"></i> <span class="num" id="dislikes-count">{{ $video->dislikes }}</span></div>
                        <div class="stat"><i class="ri-share-forward-line"></i> <span class="num" id="shares-count">{{ $video->shares }}</span></div>
                    </div>

                    <div class="actions">
                        <button id="like-btn" class="btn primary" data-slug="{{ $video->slug }}">
                            <i class="ri-thumb-up-line"></i> {{ __('videos.like') }}
                        </button>
                        <button id="dislike-btn" class="btn" data-slug="{{ $video->slug }}">
                            <i class="ri-thumb-down-line"></i> {{ __('videos.dislike') }}
                        </button>
                        <button id="share-btn" class="btn" data-slug="{{ $video->slug }}">
                            <i class="ri-share-forward-line"></i> {{ __('videos.share') }}
                        </button>
                    </div>

                    @if($video->description)
                        <div class="description">
                            <h3>{{ __('videos.description') }}</h3>
                            {!! $video->description !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="ad-slot ad-rectangle">
                <i class="ri-megaphone-line"></i> {{ __('videos.ad_label') }} 300×250
            </div>

            <div class="sidebar-card">
                <h4><i class="ri-bar-chart-2-line"></i> {{ __('videos.library') }}</h4>
                <div class="mini-stat"><span><i class="ri-eye-line"></i>{{ __('videos.views') }}</span><strong>{{ $video->views }}</strong></div>
                <div class="mini-stat"><span><i class="ri-thumb-up-line"></i>{{ __('videos.like') }}</span><strong>{{ $video->likes }}</strong></div>
                <div class="mini-stat"><span><i class="ri-thumb-down-line"></i>{{ __('videos.dislike') }}</span><strong>{{ $video->dislikes }}</strong></div>
                <div class="mini-stat"><span><i class="ri-share-forward-line"></i>{{ __('videos.share') }}</span><strong>{{ $video->shares }}</strong></div>
            </div>
        </div>

    </div>
</div>

<div class="toast" id="toast"></div>
@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const toast = document.getElementById('toast');

    function showToast(msg) {
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2200);
    }

    function postAction(url, onSuccess) {
        return fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(res => res.json())
        .then(onSuccess)
        .catch(() => showToast('Error'));
    }

    const likeBtn = document.getElementById('like-btn');
    const dislikeBtn = document.getElementById('dislike-btn');

    likeBtn?.addEventListener('click', function () {
        postAction(`/videos/${this.dataset.slug}/like`, (data) => {
            document.getElementById('likes-count').textContent = data.likes;
            document.getElementById('dislikes-count').textContent = data.dislikes;
            if (!data.success) {
                showToast(data.message);
            } else {
                likeBtn.disabled = true;
                likeBtn.classList.add('liked');
                likeBtn.innerHTML = `<i class="ri-thumb-up-fill"></i> {{ __('videos.liked') }}`;
                dislikeBtn.disabled = true;
            }
        });
    });

    dislikeBtn?.addEventListener('click', function () {
        postAction(`/videos/${this.dataset.slug}/dislike`, (data) => {
            document.getElementById('likes-count').textContent = data.likes;
            document.getElementById('dislikes-count').textContent = data.dislikes;
            if (!data.success) {
                showToast(data.message);
            } else {
                dislikeBtn.disabled = true;
                dislikeBtn.classList.add('disliked');
                dislikeBtn.innerHTML = `<i class="ri-thumb-down-fill"></i> {{ __('videos.disliked') }}`;
                likeBtn.disabled = true;
            }
        });
    });

    document.getElementById('share-btn')?.addEventListener('click', function () {
        postAction(`/videos/${this.dataset.slug}/share`, (data) => {
            document.getElementById('shares-count').textContent = data.shares;
            if (navigator.share) {
                navigator.share({ title: document.title, url: window.location.href }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href);
                showToast('{{ __('videos.copied') }}');
            }
        });
    });
</script>

<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script>
    if (document.getElementById('player')) {
        new Plyr('#player', {
            controls: [
                'play-large', 'play', 'progress', 'current-time', 'duration',
                'mute', 'volume', 'settings', 'fullscreen'
            ],
            settings: ['speed'],
        });
    }
</script>
@endpush
