@extends('layouts.app')

@section('title', $image->seo_title ?: $image->title)
@section('description', $image->seo_description ?: $image->description)
@php
    $seoCanonical = $image->canonical_url ?: url()->current();
    $seoRobots = $image->indexable ? 'index,follow' : 'noindex,follow';
    $seoImage = \App\Support\Seo::imageUrl($image->og_image ?: ($image->thumbnail_path ?: $image->image_path));
    $seoSchema = [
        \App\Support\Seo::image($image),
        \App\Support\Seo::breadcrumb([
            ['name' => app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home', 'url' => route('home')],
            ['name' => __('images.gallery'), 'url' => route('home_pages.images.index')],
            ['name' => $image->title, 'url' => $seoCanonical],
        ]),
    ];
@endphp

@push('styles')
<style>
    :root {
        --slate: #3D526B;
        --slate-tint: rgba(61, 82, 107, 0.35);
        --gold: #C89B3C;
        --border: #E6E3DC;
        --card: #FFFFFF;
        --ink: #22262B;
        --ink-soft: #5B6067;
        --radius: 16px;
        --radius-sm: 10px;
    }

    /* ===== Ad slots ===== */
    .ad-slot {
        background: repeating-linear-gradient(45deg, #F1F0EC, #F1F0EC 10px, #EAE8E2 10px, #EAE8E2 20px);
        border: 1px dashed #C9C6BD;
        border-radius: var(--radius-sm);
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

    /* ===== Breadcrumb ===== */
    .breadcrumb {
        font-size: 13px;
        color: var(--ink-soft);
        margin: 20px 0 8px;
    }
    .breadcrumb a { color: var(--slate); font-weight: 600; text-decoration: none; }
    .breadcrumb i { font-size: 12px; margin: 0 4px; vertical-align: middle; }

    /* ===== Main grid ===== */
    .layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
        padding: 12px 0 60px;
        align-items: start;
    }
    @media (max-width: 860px) {
        .layout { grid-template-columns: 1fr; }
    }

    .main-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    .main-image { width: 100%; display: block; background: #EDEBE5; }
    .main-image img { width: 100%; display: block; }
    .content-pad { padding: 28px; }

    .title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
    }
    .title-row h1 { font-family:var(--font-primary); font-weight: 800; font-size: 26px; color: var(--ink); margin: 0; }
    .byline { font-size: 13px; color: var(--ink-soft); margin-top: 6px; }
    .byline i { color: var(--slate); margin-inline-end: 4px; }

    .featured-badge {
        background: var(--gold);
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

    /* Signature: film-strip stats bar */
    .stats-strip {
        display: flex;
        background: var(--slate-tint);
        border-radius: var(--radius-sm);
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
        color: var(--slate);
    }
    .stat:last-child { border-inline-end: none; }
    .stat i { font-size: 18px; }
    .stat span.num { font-family:var(--font-primary); font-weight: 800; color: var(--ink); }

    .actions { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 22px; }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 14px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--ink);
        cursor: pointer;
        transition: all .2s ease;
        text-decoration: none;
    }
    .btn i { font-size: 17px; }
    .btn:hover { border-color: var(--slate); color: var(--slate); }
    .btn.primary { background: var(--slate); color: #fff; border-color: var(--slate); }
    .btn.primary:hover { background: #324259; color: #fff; }
    .btn.liked { background: var(--gold); border-color: var(--gold); color: #fff; }
    .btn:disabled { opacity: .7; cursor: not-allowed; }

    .description {
        border-top: 1px solid var(--border);
        padding-top: 20px;
        font-size: 15px;
        color: var(--ink);
    }
    .description h3 {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: var(--ink-soft);
        margin-bottom: 10px;
    }
    .description :is(h1,h2,h3,h4) { font-family:var(--font-primary); margin: 16px 0 8px; }
    .description p { margin: 0 0 12px; }

    .sidebar-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 20px;
    }
    .sidebar-card h4 {
        font-size: 13px;
        text-transform: uppercase;
        color: var(--ink-soft);
        margin-bottom: 12px;
        letter-spacing: .5px;
    }
    .mini-stat {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed var(--border);
        font-size: 14px;
    }
    .mini-stat:last-child { border-bottom: none; }
    .mini-stat i { color: var(--slate); margin-inline-end: 6px; }

    .toast {
        position: fixed;
        bottom: 24px;
        inset-inline-start: 50%;
        transform: translateX(-50%);
        background: var(--ink);
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
<div class="container">
    <div class="ad-slot ad-leaderboard">
        <i class="ri-megaphone-line"></i> {{ __('images.ad_label') }} 728×90
    </div>

    <div class="breadcrumb">
        <a href="{{ route('home_pages.images.index') }}">{{ __('images.home') }}</a>
        <i class="ri-arrow-left-s-line"></i>
        <a href="{{ route('home_pages.images.index') }}">{{ __('images.gallery') }}</a>
        <i class="ri-arrow-left-s-line"></i>
        {{ $image->title }}
    </div>

    <div class="layout">

        <!-- Main content -->
        <div>
            <div class="main-card">
                <div class="main-image">
                    <img src="{{ Storage::disk('public')->url($image->image_path) }}"
                         alt="{{ $image->alt_text ?: $image->title }}">
                </div>

                <div class="content-pad">
                    <div class="title-row">
                        <div>
                            <h1>{{ $image->title }}</h1>
                            @if($image->user)
                                <div class="byline">
                                    <i class="ri-user-3-line"></i>{{ __('images.by') }} {{ $image->user->name }}
                                </div>
                            @endif
                        </div>
                        @if($image->featured)
                            <span class="featured-badge"><i class="ri-star-fill"></i> Featured</span>
                        @endif
                    </div>

                    <!-- Signature stats strip -->
                    <div class="stats-strip">
                        <div class="stat"><i class="ri-eye-line"></i> <span class="num" id="views-count">{{ $image->views }}</span></div>
                        <div class="stat"><i class="ri-heart-line"></i> <span class="num" id="likes-count">{{ $image->likes }}</span></div>
                        <div class="stat"><i class="ri-share-forward-line"></i> <span class="num" id="shares-count">{{ $image->shares }}</span></div>
                        <div class="stat"><i class="ri-download-2-line"></i> <span class="num" id="downloads-count">{{ $image->downloads }}</span></div>
                    </div>

                    <div class="actions">
                        <button id="like-btn" class="btn primary" data-slug="{{ $image->slug }}">
                            <i class="ri-heart-line"></i> {{ __('images.like') }}
                        </button>
                        <button id="share-btn" class="btn" data-slug="{{ $image->slug }}">
                            <i class="ri-share-forward-line"></i> {{ __('images.share') }}
                        </button>
                        <a href="{{ route('home_pages.images.download', $image->slug) }}" class="btn" id="download-btn">
                            <i class="ri-download-2-line"></i> {{ __('images.download') }}
                        </a>
                    </div>

                    @if($image->description)
                        <div class="description">
                            <h3>{{ __('images.description') }}</h3>
                            {!! $image->description !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <div class="ad-slot ad-rectangle">
                <i class="ri-megaphone-line"></i> {{ __('images.ad_label') }} 300×250
            </div>

            <div class="sidebar-card">
                <h4><i class="ri-bar-chart-2-line"></i> {{ __('images.gallery') }}</h4>
                <div class="mini-stat"><span><i class="ri-eye-line"></i>{{ __('images.views') }}</span><strong>{{ $image->views }}</strong></div>
                <div class="mini-stat"><span><i class="ri-heart-line"></i>{{ __('images.like') }}</span><strong>{{ $image->likes }}</strong></div>
                <div class="mini-stat"><span><i class="ri-share-forward-line"></i>{{ __('images.share') }}</span><strong>{{ $image->shares }}</strong></div>
                <div class="mini-stat"><span><i class="ri-download-2-line"></i>{{ __('images.download') }}</span><strong>{{ $image->downloads }}</strong></div>
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

    document.getElementById('like-btn')?.addEventListener('click', function () {
        const btn = this;
        const slug = btn.dataset.slug;

        fetch(`/images/${slug}/like`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('likes-count').textContent = data.likes;
            if (!data.success) {
                showToast(data.message);
            } else {
                btn.disabled = true;
                btn.classList.add('liked');
                btn.innerHTML = `<i class="ri-heart-fill"></i> {{ __('images.liked') }}`;
            }
        })
        .catch(() => showToast('Error'));
    });

    document.getElementById('share-btn')?.addEventListener('click', function () {
        const slug = this.dataset.slug;

        fetch(`/images/${slug}/share`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('shares-count').textContent = data.shares;

            if (navigator.share) {
                navigator.share({ title: document.title, url: window.location.href }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href);
                showToast('{{ __('images.copied') }}');
            }
        });
    });
</script>
@endpush
