@extends('layouts.visitor')
@section('title', 'الأسئلة الشائعة | شركة الديوان للاستشارات الهندسية')
@section('description', 'أسئلة شائعة عن خدمات الديوان وطلب الخدمة والمستندات والتكلفة.')
@section('content')
@php($faqs = config('site.faqs'))
<section class="page-hero"><div class="container"><p class="eyebrow">الأسئلة الشائعة</p><h1>إجابات قصيرة قبل أن تبدأ الطلب</h1><p>جمعنا الأسئلة المتكررة حول الخدمات والمستندات والتكلفة حتى تتضح الصورة قبل التواصل.</p></div></section>
<section class="section"><div class="container"><div class="grid">@foreach ($faqs as $faq)<details class="card card-pad" @if($loop->first) open @endif><summary style="cursor:pointer;font-size:20px;font-weight:900;color:var(--deep-slate)">{{ $faq['question'] }}</summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div></div></section>
@include('partials.final-cta')
@endsection