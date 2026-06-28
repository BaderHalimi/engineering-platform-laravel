@extends('layouts.visitor')
@section('title', 'المشاريع | شركة الديوان للاستشارات الهندسية')
@section('description', 'نماذج أعمال ومشاريع هندسية مصنفة حسب الخدمة والمدينة.')
@section('content')
@php($projects = config('site.projects'))
<section class="page-hero"><div class="container"><p class="eyebrow">المشاريع والأعمال</p><h1>نماذج توضح طريقة التفكير قبل التنفيذ</h1><p>نعرض نماذج أعمال قابلة للتصنيف حسب نوع الخدمة والمدينة، لتوضيح طبيعة المخرجات وليس للمبالغة التسويقية.</p></div></section>
<section class="section"><div class="container"><div class="grid three-grid">@foreach ($projects as $project)<article class="card" style="overflow:hidden"><div class="project-visual"><div class="project-pattern"><span></span><span></span><span></span><span></span><span></span></div></div><div class="card-pad"><div class="meta"><span>{{ $project['service'] }}</span><span>{{ $project['city'] }}</span></div><h3>{{ $project['title'] }}</h3><p>{{ $project['summary'] }}</p></div></article>@endforeach</div></div></section>
@include('partials.final-cta')
@endsection