@php
    $locale = in_array(app()->getLocale(), ['ar', 'en'], true) ? app()->getLocale() : 'ar';
    $direction = $locale === 'ar' ? 'rtl' : 'ltr';
    $code = trim($__env->yieldContent('code')) ?: '500';
    $title = __("errors.pages.{$code}.title", [], $locale);
    $description = __("errors.pages.{$code}.description", [], $locale);
    $brand = config('app.name', __('errors.brand', [], $locale));
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $direction }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $code }} | {{ $title }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}">
    @include('partials.local-fonts')
    <style>
        :root{--teal:#526970;--teal-dark:#3d5258;--gold:#f5ad2a;--gold-dark:#d89320;--ink:#1e2a30;--line:#e7e2d8;--soft:#f7f9f9}
        *{box-sizing:border-box}
        html,body{margin:0;min-height:100%}
        body{min-height:100vh;font-family:var(--font-primary);color:var(--ink);background:var(--soft);overflow-x:hidden}
        .page{position:relative;isolation:isolate;min-height:100vh;display:grid;place-items:center;padding:32px 20px}
        .grid{position:absolute;inset:0;z-index:-3;background-image:radial-gradient(circle at 1px 1px,rgba(82,105,112,.13) 1px,transparent 0);background-size:24px 24px}
        .glow{position:absolute;z-index:-2;width:420px;height:420px;border-radius:50%;filter:blur(90px);opacity:.19}
        .glow-one{background:var(--gold);inset-block-start:-180px;inset-inline-end:-120px}
        .glow-two{background:var(--teal);inset-block-end:-200px;inset-inline-start:-100px}
        .card{width:min(100%,760px);position:relative;overflow:hidden;text-align:center;background:rgba(255,255,255,.94);border:1px solid rgba(231,226,216,.9);border-radius:32px;padding:44px 28px 36px;box-shadow:0 28px 80px -36px rgba(61,82,88,.42)}
        .card:before,.card:after{content:'';position:absolute;width:72px;height:72px;border-color:var(--gold);opacity:.7}
        .card:before{inset-block-start:18px;inset-inline-start:18px;border-block-start:3px solid;border-inline-start:3px solid;border-start-start-radius:14px}
        .card:after{inset-block-end:18px;inset-inline-end:18px;border-block-end:3px solid;border-inline-end:3px solid;border-end-end-radius:14px}
        .logo-wrap{width:90px;height:90px;margin:0 auto 22px;display:grid;place-items:center;border-radius:26px;background:linear-gradient(145deg,var(--teal),var(--teal-dark));box-shadow:0 15px 32px -14px rgba(61,82,88,.75);transform:rotate(3deg)}
        .logo{width:70px;height:70px;object-fit:contain;transform:rotate(-3deg)}
        .code{margin:0;color:var(--gold);font-size:clamp(4.8rem,17vw,8rem);font-weight:900;line-height:.95;letter-spacing:-.05em;text-shadow:0 8px 25px rgba(245,173,42,.18)}
        .rule{width:68px;height:5px;margin:22px auto;border-radius:999px;background:linear-gradient(90deg,var(--gold),var(--gold-dark))}
        h1{margin:0;color:var(--teal-dark);font-size:clamp(1.55rem,4vw,2.2rem);font-weight:800}
        .description{max-width:570px;margin:14px auto 0;color:#64747a;font-size:1.02rem;line-height:1.9}
        .actions{display:flex;justify-content:center;flex-wrap:wrap;gap:12px;margin-top:28px}
        .button{display:inline-flex;align-items:center;justify-content:center;gap:9px;min-width:160px;padding:12px 22px;border:0;border-radius:999px;font:700 .95rem var(--font-primary);text-decoration:none;cursor:pointer;transition:transform .25s ease,box-shadow .25s ease}
        .button:hover{transform:translateY(-2px)}
        .primary{color:#fff;background:linear-gradient(135deg,var(--gold),var(--gold-dark));box-shadow:0 12px 25px -12px rgba(245,173,42,.8)}
        .secondary{color:var(--teal-dark);background:#fff;border:1px solid #dfe5e7;box-shadow:0 10px 24px -18px rgba(61,82,88,.7)}
        .icon{font-size:1.2rem;line-height:1}
        .note{margin:24px 0 0;color:#98a3a7;font-size:.78rem}
        @media(max-width:520px){.page{padding:16px}.card{padding:34px 18px 29px;border-radius:25px}.logo-wrap{width:76px;height:76px;border-radius:22px}.logo{width:58px;height:58px}.actions{flex-direction:column}.button{width:100%}}
        @media(prefers-reduced-motion:no-preference){.card{animation:appear .6s cubic-bezier(.2,.8,.2,1) both}@keyframes appear{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:none}}}
    </style>
</head>
<body>
<main class="page">
    <div class="grid" aria-hidden="true"></div>
    <div class="glow glow-one" aria-hidden="true"></div>
    <div class="glow glow-two" aria-hidden="true"></div>
    <section class="card" aria-labelledby="error-title">
        <div class="logo-wrap"><img class="logo" src="{{ asset('logo.png') }}" alt="{{ $brand }}"></div>
        <p class="code">{{ $code }}</p>
        <div class="rule"></div>
        <h1 id="error-title">{{ $title }}</h1>
        <p class="description">{{ $description }}</p>
        <div class="actions">
            <a class="button primary" href="{{ url('/') }}"><span class="icon" aria-hidden="true">⌂</span>{{ __('errors.home', [], $locale) }}</a>
            <button class="button secondary" type="button" onclick="history.back()"><span class="icon" aria-hidden="true">↩</span>{{ __('errors.back', [], $locale) }}</button>
        </div>
        <p class="note">{{ __('errors.support', [], $locale) }}</p>
    </section>
</main>
</body>
</html>
