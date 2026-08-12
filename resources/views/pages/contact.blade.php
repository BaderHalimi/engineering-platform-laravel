@extends('layouts.visitor')
@section('title', 'تواصل معنا | شركة الديوان للاستشارات الهندسية')
@section('description', 'تواصل مع شركة الديوان للاستشارات الهندسية في المدينة المنورة عبر الهاتف أو واتساب أو نموذج
    التواصل.')
@section('content')
    @php($brand = config('site.brand'))
    <section class="page-hero">
        <div class="container">
            <p class="eyebrow">تواصل معنا</p>
            <h1>تواصل مباشر لقرار هندسي أوضح</h1>
            <p>أرسل استفسارك أو ابدأ بطلب خدمة، وسنراجع المعلومات معك بطريقة منظمة قبل أي خطوة لاحقة.</p>
        </div>
    </section>
    <section class="section">
        <div class="container two-col">
            <div class="grid">
                <article class="card card-pad"><span class="icon-badge">م</span>
                    <h3>العنوان</h3>
                    <p>{{ $brand['address'] }}</p>
                </article>
                <article class="card card-pad"><span class="icon-badge">ج</span>
                    <h3>الهاتف وواتساب</h3>
                    <p>{{ $brand['phone'] }}</p>
                    <div class="button-row" style="margin-top:16px"><a class="btn btn-primary"
                            href="{{ $brand['whatsapp'] }}" target="_blank" rel="noopener">واتساب</a></div>
                </article>
                <article class="card card-pad"><span class="icon-badge">@</span>
                    <h3>البريد وساعات العمل</h3>
                    <p>{{ $brand['email'] }}</p>
                    <p>{{ $brand['hours'] }}</p>
                </article>
                <div class="visual-panel"></div>
            </div>
            <form class="form-card form-grid" action="/contact" method="GET"><label class="field">الاسم<input
                        name="name" required></label><label class="field">رقم الجوال<input name="phone"
                        placeholder="05xxxxxxxx"></label><label class="field span-2">البريد الإلكتروني<input type="email"
                        name="email"></label><label class="field span-2">الموضوع<input name="subject"
                        placeholder="استفسار عن خدمة تصميم ورخصة"></label><label class="field span-2">الرسالة
                    <textarea name="message" placeholder="اكتب رسالتك هنا"></textarea>
                </label>
                <div class="span-2"><button class="btn btn-primary" type="submit" style="width:100%">إرسال الرسالة</button>
                </div>
            </form>
        </div>
    </section>
@endsection
