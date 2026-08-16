@extends('layouts.app')

@php
    $serviceName = $service->name;
    $serviceSummary = $service->short_description ?: strip_tags($service->description ?? '');
    $asset = fn ($path) => $path ? asset('storage/' . ltrim($path, '/')) : null;
    $seoImage = \App\Support\Seo::imageUrl($service->thumbnail);
    $seoSchema = [
        \App\Support\Seo::service($service),
        \App\Support\Seo::breadcrumb([
            ['name' => app()->getLocale() === 'ar' ? 'الرئيسية' : 'Home', 'url' => route('home')],
            ['name' => app()->getLocale() === 'ar' ? 'الخدمات' : 'Services', 'url' => route('home_pages.services.index')],
            ['name' => $serviceName, 'url' => url()->current()],
        ]),
    ];
@endphp

@section('title', $service->meta_title ?: $serviceName)
@section('description', $service->meta_description ?: $serviceSummary)

@section('content')
<section class="relative overflow-hidden bg-white">
    <div class="absolute inset-0 blueprint-grid pointer-events-none"></div>
    <div class="site-container relative z-10 py-16 md:py-24">
        <div class="grid lg:grid-cols-[1.1fr_.9fr] gap-10 items-center">
            <div>
                <div class="inline-flex items-center gap-2 border border-[var(--gold)]/40 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-5">
                    <i class="ri-compasses-2-line"></i> {{ app()->getLocale() === 'ar' ? 'خدمة هندسية' : 'Engineering Service' }}
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-[var(--teal)] leading-tight mb-5">{{ $serviceName }}</h1>
                @if($service->short_description)
                    <p class="max-w-2xl text-gray-500 text-lg leading-9 mb-8">{{ $service->short_description }}</p>
                @endif
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('service-request.create', ['service' => $service->slug]) }}" class="btn-primary inline-flex items-center gap-2 rounded-full px-8 py-4 text-white font-bold">
                        {{ app()->getLocale() === 'ar' ? 'اطلب الخدمة' : 'Request service' }}
                        <i class="ri-arrow-left-line"></i>
                    </a>
                    <a href="{{ route('home_pages.services.index') }}" class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-7 py-4 font-bold text-[var(--teal)] hover:border-[var(--gold)] transition">
                        {{ app()->getLocale() === 'ar' ? 'كل الخدمات' : 'All services' }}
                    </a>
                </div>
            </div>

            <div class="relative">
                @if($service->thumbnail)
                    <img src="{{ $asset($service->thumbnail) }}" alt="{{ $serviceName }}" class="w-full aspect-[4/3] object-cover rounded-3xl shadow-2xl border-4 border-white">
                @else
                    <div class="aspect-[4/3] rounded-3xl bg-[var(--bg-soft)] border border-[var(--line)] grid place-items-center shadow-xl">
                        <i class="{{ $service->icon ?: 'ri-building-2-line' }} text-7xl text-[var(--gold-dark)]"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="bg-[var(--bg-soft)] py-14 md:py-20">
    <div class="site-container grid lg:grid-cols-[.72fr_1.28fr] gap-8">
        <aside class="space-y-4">
            @if($service->estimated_time || $service->price || $service->documented || $service->visit_required)
                <div class="bg-white border border-[var(--line)] rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-black text-[var(--teal)] mb-5">{{ app()->getLocale() === 'ar' ? 'معلومات الخدمة' : 'Service Info' }}</h2>
                    <div class="space-y-3 text-sm">
                        @if($service->estimated_time)<div class="flex justify-between gap-4"><span class="text-gray-500">{{ __('home.services.duration_label') }}</span><strong>{{ $service->estimated_time }}</strong></div>@endif
                        @if($service->price)<div class="flex justify-between gap-4"><span class="text-gray-500">{{ app()->getLocale() === 'ar' ? 'السعر' : 'Price' }}</span><strong>{{ $service->price }}</strong></div>@endif
                        @if($service->documented)<div class="flex justify-between gap-4"><span class="text-gray-500">{{ __('home.services.documented') }}</span><strong><i class="ri-check-line text-green-600"></i></strong></div>@endif
                        @if($service->visit_required)<div class="flex justify-between gap-4"><span class="text-gray-500">{{ __('home.services.visit_required') }}</span><strong><i class="ri-check-line text-[var(--gold-dark)]"></i></strong></div>@endif
                    </div>
                </div>
            @endif
        </aside>

        <article class="bg-white border border-[var(--line)] rounded-2xl p-6 md:p-8 shadow-sm">
            @if($service->description)
                <div class="prose max-w-none text-[var(--ink)] leading-9">
                    {!! $service->description !!}
                </div>
            @endif

            @foreach([
                'advantages' => app()->getLocale() === 'ar' ? 'المزايا' : 'Advantages',
                'requirements' => app()->getLocale() === 'ar' ? 'المتطلبات' : 'Requirements',
            ] as $field => $title)
                @if(!empty($service->{$field}))
                    <h2 class="mt-8 mb-4 text-2xl font-black text-[var(--teal)]">{{ $title }}</h2>
                    <div class="grid md:grid-cols-2 gap-3">
                        @foreach($service->{$field} as $item)
                            <div class="rounded-xl border border-[var(--line)] bg-[var(--bg-soft)] px-4 py-3 font-bold text-[var(--teal)]">{{ $item }}</div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </article>
    </div>
</section>
@endsection
