@extends('layouts.visitor')
@section('title', 'الخدمات | شركة الديوان للاستشارات الهندسية')
@section('description', 'خدمات التصميم والرخص والإشراف والسلامة والواجهات وإدارة المشاريع والمساحة.')
@section('content')
@php($services = config('site.services'))
<section class="page-hero"><div class="container"><p class="eyebrow">الخدمات</p><h1>خدمات هندسية واضحة من أول قرار</h1><p>كل خدمة مصممة لتشرح للعميل ماذا يحتاج، ما الذي سيتم تنفيذه، وما المستندات المتوقعة قبل الانتقال للخطوة التالية.</p></div></section>
<section class="section"><div class="container"><div class="grid three-grid">@foreach ($services as $service)<article class="card card-pad"><span class="icon-badge">{{ $service['number'] }}</span><h3>{{ $service['title'] }}</h3><p>{{ $service['summary'] }}</p><div class="pill-list"><span class="pill">{{ $service['audience'] }}</span></div><div class="button-row" style="margin-top:20px"><a class="btn btn-light" href="/services/{{ $service['slug'] }}">معرفة المزيد</a><a class="btn btn-primary" href="/request-service?service={{ $service['slug'] }}">طلب الخدمة</a></div></article>@endforeach</div></div></section>
<section class="section muted-section"><div class="container two-col"><div><p class="eyebrow">آلية عامة</p><h2 class="section-title">نبدأ بفهم الاحتياج ثم نرتب الطريق</h2><p class="section-copy">هدفنا أن يعرف العميل لماذا يحتاج الخدمة، ما نطاقها، وما المعلومات المطلوبة قبل أن يتحول التواصل إلى طلب فعلي.</p></div><div class="grid">@foreach (['فهم نوع المشروع', 'تحديد الخدمة المناسبة', 'تجهيز المستندات', 'متابعة الخطوة التالية'] as $item)<article class="card card-pad"><span class="icon-badge">{{ $loop->iteration }}</span><h3>{{ $item }}</h3></article>@endforeach</div></div></section>
@include('partials.final-cta')
@endsection