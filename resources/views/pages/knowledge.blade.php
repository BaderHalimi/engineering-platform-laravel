@extends('layouts.visitor')
@section('title', 'المعرفة الهندسية | شركة الديوان للاستشارات الهندسية')
@section('description', 'مقالات هندسية تساعد العميل على فهم الرخص والتصميم والإشراف ومتطلبات السلامة.')
@section('content')
@php($articles = config('site.articles'))
<section class="page-hero"><div class="container"><p class="eyebrow">المعرفة الهندسية</p><h1>مقالات تساعدك قبل التواصل</h1><p>محتوى مختصر وواضح يشرح خطوات الرخص والخدمات والمستندات حتى يبدأ العميل من معرفة لا من تخمين.</p></div></section>
<section class="section"><div class="container"><div class="grid three-grid">@foreach ($articles as $article)<article class="card card-pad"><span class="icon-badge">{{ $loop->iteration }}</span><div class="meta"><span>{{ $article['category'] }}</span></div><h3>{{ $article['title'] }}</h3><p>{{ $article['excerpt'] }}</p><div class="button-row" style="margin-top:18px"><a class="btn btn-light" href="/knowledge/{{ $article['slug'] }}">اقرأ المقال</a></div></article>@endforeach</div></div></section>
<section class="section muted-section"><div class="container two-col"><div><p class="eyebrow">لماذا المعرفة؟</p><h2 class="section-title">القرار الهندسي الجيد يبدأ بسؤال واضح</h2><p class="section-copy">نكتب بلغة مباشرة عن الرخص، الإشراف، الدفاع المدني، والمستندات المطلوبة حتى تقل المفاجآت في بداية المشروع.</p></div><div class="visual-panel"></div></div></section>
@endsection