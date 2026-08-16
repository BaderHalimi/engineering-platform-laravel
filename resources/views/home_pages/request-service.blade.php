@extends('layouts.app')

@section('title', app()->getLocale() === 'ar' ? 'اطلب خدمة' : 'Request Service')

@section('description', app()->getLocale() === 'ar'
    ? 'أرسل طلب خدمة هندسية لفريق الديوان مع تفاصيل المشروع والمرفقات المطلوبة.'
    : 'Send an engineering service request to Al Diwan with project details and required documents.')

@section('content')
@php
    $locale = app()->getLocale();
    $tr = function ($field) use ($locale) {
        if (is_array($field)) {
            return $field[$locale] ?? $field['ar'] ?? (reset($field) ?: '');
        }

        return $field ?? '';
    };
@endphp

<section class="relative overflow-hidden bg-white py-12 md:py-20">
  <div class="absolute inset-0 blueprint-grid pointer-events-none"></div>
  <div class="absolute -top-24 -end-24 h-72 w-72 rounded-full bg-[var(--gold)]/10 blur-3xl pointer-events-none"></div>

  <div class="site-container relative z-10">
    @if(session('success'))
      <div class="mb-6 rounded-2xl bg-green-50 border border-green-100 px-5 py-4 text-green-700 font-bold flex items-center gap-2">
        <i class="ri-checkbox-circle-fill text-xl"></i>
        {{ session('success') }}
      </div>
    @endif

    <div class="grid lg:grid-cols-[.82fr_1.18fr] gap-7 md:gap-10 items-start">
      <aside class="space-y-5">
        <div class="rounded-3xl border border-[var(--line)] bg-white p-6 md:p-8 shadow-xl shadow-gray-200/50">
          <div class="inline-flex items-center gap-2 bg-[var(--gold)]/10 text-[var(--gold-dark)] px-4 py-1.5 rounded-full text-xs md:text-sm font-bold mb-5">
            <i class="ri-customer-service-2-line"></i>
            {{ app()->getLocale() === 'ar' ? 'طلب خدمة' : 'Service request' }}
          </div>
          <h1 class="text-3xl md:text-5xl font-black text-[var(--teal)] mb-4 leading-tight">
            {{ app()->getLocale() === 'ar' ? 'احجز استشارتك الهندسية الآن' : 'Book your engineering consultation' }}
          </h1>
          <div class="section-title-underline mb-5"></div>
          <p class="text-gray-500 text-sm md:text-base leading-8">
            {{ app()->getLocale() === 'ar'
                ? 'املأ البيانات الأساسية وسنراجع الطلب ثم يتواصل معك الفريق لتحديد الخطوة التالية بوضوح.'
                : 'Fill in the basic details and our team will review your request, then contact you with the next step.' }}
          </p>
        </div>

        <div class="rounded-3xl border border-[var(--gold)]/20 bg-[var(--bg-soft)] p-6 shadow-sm">
          <h2 class="text-lg md:text-xl font-extrabold text-[var(--teal)] mb-4">
            {{ app()->getLocale() === 'ar' ? 'ماذا يحدث بعد الإرسال؟' : 'What happens next?' }}
          </h2>
          <div class="space-y-4 text-sm text-gray-500 leading-7">
            <div class="flex gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-[var(--gold-dark)] font-bold">1</span>
              <p>{{ app()->getLocale() === 'ar' ? 'نراجع نوع الخدمة وتفاصيل المشروع.' : 'We review the selected service and project details.' }}</p>
            </div>
            <div class="flex gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-[var(--gold-dark)] font-bold">2</span>
              <p>{{ app()->getLocale() === 'ar' ? 'نتأكد من المستندات المطلوبة إذا كانت الخدمة موثقة.' : 'We check required documents for documented services.' }}</p>
            </div>
            <div class="flex gap-3">
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-[var(--gold-dark)] font-bold">3</span>
              <p>{{ app()->getLocale() === 'ar' ? 'يتواصل معك الفريق خلال أقرب وقت.' : 'Our team contacts you as soon as possible.' }}</p>
            </div>
          </div>
        </div>
      </aside>

      @include('partials.home.service-request-form', [
        'services' => $services,
        'tr' => $tr,
        'selectedServiceId' => $selectedServiceId ?? null,
      ])
    </div>
  </div>
</section>
@endsection
