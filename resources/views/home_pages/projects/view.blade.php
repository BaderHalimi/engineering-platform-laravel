{{-- resources/views/home_pages/projects/view.blade.php --}}
@extends('layouts.app')

@section('title', $project->meta_title ?: $project->title)

@push('meta')
    <meta name="description" content="{{ $project->meta_description ?: $project->title }}">
@endpush

@push('styles')
<style>
    .breadcrumb {
        font-size: 13px;
        color: var(--slate);
        margin: 24px 0 16px;
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }
    .breadcrumb a {
        color: var(--teal);
        font-weight: 600;
        text-decoration: none;
        transition: color .2s ease;
    }
    .breadcrumb a:hover { color: var(--teal-dark); }
    .breadcrumb i { font-size: 12px; color: #C9C6BD; }
    .breadcrumb .current { color: var(--ink); font-weight: 600; }

    .main-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 20px;
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto 48px;
        box-shadow: 0 20px 50px -20px rgba(34,38,43,.15);
    }

    .hero-image {
        width: 100%;
        display: block;
        background: var(--paper);
        position: relative;
    }
    .hero-image img { width: 100%; display: block; max-height: 440px; object-fit: cover; }
    .hero-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(34,38,43,.55), transparent 45%);
    }
    .hero-image .hero-caption {
        position: absolute;
        bottom: 20px;
        inset-inline-start: 28px;
        inset-inline-end: 28px;
        z-index: 1;
    }
    .hero-image .hero-caption .category-tag {
        background: var(--gold);
        color: #22262B;
    }

    .content-pad { padding: 36px; }

    .title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--line);
    }
    .title-row h1 {
        font-family: var(--font-display);
        font-weight: 800;
        font-size: 30px;
        color: var(--ink);
        margin: 0;
        line-height: 1.3;
    }
    .category-tag {
        background: rgba(82,105,112,.12);
        color: var(--teal-dark);
        font-size: 13px;
        font-weight: 700;
        padding: 7px 16px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .description { font-size: 15.5px; color: var(--ink); line-height: 1.9; }
    .description :is(h1,h2,h3,h4) { font-family: var(--font-display); margin: 20px 0 10px; color: var(--ink); }
    .description p { margin: 0 0 14px; }
    .description img { border-radius: 12px; max-width: 100%; height: auto; }
    .description ul, .description ol { padding-inline-start: 22px; margin: 0 0 14px; }

    .attachments-section {
        border-top: 1px solid var(--line);
        margin-top: 28px;
        padding-top: 24px;
    }
    .attachments-section h3 {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        color: var(--slate);
        margin: 0 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .attachment-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border: 1px solid var(--line);
        border-radius: 12px;
        margin-bottom: 8px;
        text-decoration: none;
        color: var(--ink);
        font-size: 14px;
        font-weight: 600;
        background: var(--paper);
        transition: all .2s ease;
    }
    .attachment-item:hover {
        border-color: var(--teal);
        background: #fff;
        color: var(--teal-dark);
        transform: translateX(-2px);
    }
    [dir="rtl"] .attachment-item:hover { transform: translateX(2px); }
    .attachment-item .icon-wrap {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: rgba(82,105,112,.12);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .attachment-item i:first-child { font-size: 18px; color: var(--teal); }
    .attachment-item .download-icon { margin-inline-start: auto; color: #C9C6BD; font-size: 16px; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4">

    <div class="breadcrumb">
        <a href="{{ route('home_pages.projects.index') }}">
            {{ app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home' }}
        </a>
        <i class="ri-arrow-left-s-line"></i>
        <a href="{{ route('home_pages.projects.index') }}">
            {{ app()->getLocale() === 'ar' ? 'المشاريع' : 'Projects' }}
        </a>
        <i class="ri-arrow-left-s-line"></i>
        <span class="current">{{ $project->title }}</span>
    </div>

    <div class="main-card">
        @if($project->image)
            <div class="hero-image">
                <img src="{{ asset('storage/' . ltrim($project->image, '/')) }}" alt="{{ $project->title }}">
                @if($project->category)
                    <div class="hero-caption">
                        <span class="category-tag">
                            <i class="ri-folder-line"></i> {{ $project->category->name }}
                        </span>
                    </div>
                @endif
            </div>
        @endif

        <div class="content-pad">
            <div class="title-row">
                <h1>{{ $project->title }}</h1>
                @if($project->category && !$project->image)
                    <span class="category-tag">
                        <i class="ri-folder-line"></i> {{ $project->category->name }}
                    </span>
                @endif
            </div>

            @if($project->description)
                <div class="description">
                    {!! $project->description !!}
                </div>
            @endif

            @if(!empty($project->attachments))
                <div class="attachments-section">
                    <h3><i class="ri-attachment-2"></i> {{ app()->getLocale() === 'ar' ? 'المرفقات' : 'Attachments' }}</h3>
                    @foreach($project->attachments as $attachment)
                        <a href="{{ asset('storage/' . ltrim($attachment, '/')) }}" class="attachment-item" target="_blank">
                            <span class="icon-wrap"><i class="ri-file-line"></i></span>
                            {{ basename($attachment) }}
                            <i class="ri-download-2-line download-icon"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
