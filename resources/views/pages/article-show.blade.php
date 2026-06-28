@extends('layouts.visitor')
@section('title', $article['title'] . ' | المعرفة الهندسية')
@section('description', $article['excerpt'])
@section('content')
<section class="page-hero"><div class="container"><p class="eyebrow">{{ $article['category'] }}</p><h1>{{ $article['title'] }}</h1><p>{{ $article['excerpt'] }}</p></div></section>
<section class="section"><div class="container two-col"><article class="card card-pad" style="font-size:18px;line-height:2.1">@foreach ($article['body'] as $paragraph)<p>{{ $paragraph }}</p>@endforeach<div class="button-row" style="margin-top:24px"><a class="btn btn-primary" href="/request-service">اطلب خدمة</a><a class="btn btn-light" href="/knowledge">كل المقالات</a></div></article><aside class="card card-pad"><span class="icon-badge">i</span><h3>تذكير مهم</h3><p>المحتوى للتوضيح العام، ولا يغني عن مراجعة تفاصيل مشروعك ومستنداته مع فريق هندسي مختص.</p><div class="pill-list"><span class="pill">رخص البناء</span><span class="pill">الكود السعودي</span><span class="pill">استشارة هندسية</span></div></aside></div></section>
@endsection