@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="static-page-wrapper">
    <div class="static-page-container">
        <header class="static-page-header">
            <span class="static-page-badge">EngHub</span>
            <h1 class="static-page-title">{{ $title }}</h1>
            <p class="static-page-subtitle">آخر تحديث يظهر داخل النص أدناه</p>
        </header>

        <div id="static-page-content" class="static-page-content">
            <div class="static-page-loading">
                <span class="spinner"></span>
                جاري تحميل المحتوى...
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    const rawMarkdown = @json($content);
    const target = document.getElementById('static-page-content');
    target.innerHTML = marked.parse(rawMarkdown || '');
</script>

<style>
.static-page-wrapper {
    background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
    min-height: calc(100vh - 200px);
    padding: 4rem 1.5rem;
}

.static-page-container {
    max-width: 760px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #eef0f3;
    border-radius: 20px;
    padding: 3rem 3.5rem;
    box-shadow: 0 4px 24px rgba(15, 23, 42, 0.04);
}

.static-page-header {
    text-align: center;
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f1f3f5;
}

.static-page-badge {
    display: inline-block;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 0.3rem 0.9rem;
    border-radius: 999px;
    letter-spacing: 0.03em;
    margin-bottom: 1rem;
}

.static-page-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0 0 0.5rem;
}

.static-page-subtitle {
    color: #94a3b8;
    font-size: 0.9rem;
    margin: 0;
}

.static-page-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    color: #94a3b8;
    font-size: 0.9rem;
    padding: 3rem 0;
}

.spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #e2e8f0;
    border-top-color: #4f46e5;
    border-radius: 50%;
    animation: spin 0.7s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* ===== تنسيق محتوى الماركداون ===== */
.static-page-content {
    color: #334155;
    font-size: 1.02rem;
    line-height: 1.9;
}

.static-page-content h1 {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1e293b;
    margin: 2rem 0 1rem;
    padding-bottom: 0.6rem;
    border-bottom: 2px solid #f1f5f9;
}

.static-page-content h1:first-child {
    margin-top: 0;
}

.static-page-content h2 {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    margin: 1.8rem 0 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.static-page-content h2::before {
    content: "";
    width: 4px;
    height: 1.1rem;
    background: #4f46e5;
    border-radius: 4px;
    display: inline-block;
}

.static-page-content h3 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #334155;
    margin: 1.4rem 0 0.6rem;
}

.static-page-content p {
    margin-bottom: 1.1rem;
    color: #475569;
}

.static-page-content ul,
.static-page-content ol {
    margin: 0 0 1.2rem;
    padding-inline-start: 1.4rem;
}

.static-page-content li {
    margin-bottom: 0.5rem;
    color: #475569;
}

.static-page-content li::marker {
    color: #4f46e5;
}

.static-page-content strong {
    font-weight: 700;
    color: #1e293b;
}

.static-page-content a {
    color: #4f46e5;
    text-decoration: none;
    border-bottom: 1px solid #c7d2fe;
    transition: border-color 0.15s;
}

.static-page-content a:hover {
    border-color: #4f46e5;
}

.static-page-content code {
    background: #f1f5f9;
    padding: 0.15rem 0.4rem;
    border-radius: 6px;
    font-size: 0.85em;
    color: #db2777;
}

.static-page-content blockquote {
    border-inline-start: 3px solid #c7d2fe;
    background: #f8fafc;
    padding: 0.8rem 1.2rem;
    border-radius: 0 8px 8px 0;
    color: #64748b;
    margin: 1.2rem 0;
}

.static-page-content hr {
    border: none;
    border-top: 1px solid #f1f5f9;
    margin: 2rem 0;
}

@media (max-width: 640px) {
    .static-page-container {
        padding: 2rem 1.5rem;
        border-radius: 14px;
    }
    .static-page-title {
        font-size: 1.5rem;
    }
}
</style>
@endsection
