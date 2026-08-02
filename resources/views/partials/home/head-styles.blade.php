<style>
  :root{
    --teal:#526970;
    --teal-dark:#3d5258;
    --teal-light:#6b858d;
    --gold:#f5ad2a;
    --gold-dark:#d89320;
    --ink:#1E2A30;
    --line:#E7E2D8;
    --bg-soft:#fafbfc;
  }
  *{ font-family:'Cairo','Tajawal',sans-serif; }
  html{ scroll-behavior:smooth; }
  body{ background-color:#fff; color:var(--teal); overflow-x:hidden; }
  .site-container{ width:100%; margin-inline:auto; padding-inline:1.25rem; }
  .site-nav{ width:calc(100% - 2rem); margin-inline:auto; }
  .site-topbar{ padding-inline:1.25rem; }
  @media (min-width:768px){
    .site-container{ padding-inline:10vw; }
    .site-nav{ width:80%; }
    .site-topbar{ padding-inline:10vw; }
  }
  .font-body{ font-family:'IBM Plex Sans Arabic',sans-serif; }
  .font-display{font-family:'Tajawal',sans-serif;}
  [dir="ltr"] .font-body, [dir="ltr"] .font-display{ font-family:'Tajawal','Cairo',sans-serif; }
  .nav-link{ position:relative; transition:color .35s ease, background-color .35s ease, transform .35s ease; z-index:1; }
  .nav-link:hover{ color:var(--teal); }
  .nav-link.active{ color:#fff !important; background-color:var(--gold) !important; box-shadow:0 6px 16px -6px rgba(245,173,42,.55); }
  .nav-link:not(.active):hover{ background-color:#f3f4f6; }
  .btn-primary{ background:linear-gradient(135deg, var(--gold), var(--gold-dark)); color:#fff; box-shadow:0 10px 24px -10px rgba(245,173,42,.6); transition:transform .3s ease, box-shadow .3s ease; }
  .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 14px 28px -8px rgba(245,173,42,.7); }
  .btn-blue,.btn-secondary{ background:linear-gradient(135deg, var(--teal-light), var(--teal-dark)); color:#fff; box-shadow:0 10px 24px -10px rgba(82,105,112,.55); transition:transform .3s ease, box-shadow .3s ease; }
  .btn-blue:hover,.btn-secondary:hover{ transform:translateY(-2px); box-shadow:0 14px 28px -8px rgba(82,105,112,.65); }
  .blob{ position:absolute; border-radius:50%; filter:blur(80px); opacity:.35; pointer-events:none; }
  .geo-pattern{ background-image:radial-gradient(circle at 1px 1px, rgba(82,105,112,.08) 1px, transparent 0); background-size:22px 22px; }
  @keyframes pulse-ring{ 0%{ box-shadow:0 0 0 0 rgba(245,173,42,.4); } 70%{ box-shadow:0 0 0 18px rgba(245,173,42,0); } 100%{ box-shadow:0 0 0 0 rgba(245,173,42,0); } }
  .pulse-ring{ animation:pulse-ring 2.2s infinite; }
  .corner{ position:absolute; width:18px; height:18px; border-color:var(--gold); }
  .corner-tl{ top:10px; inset-inline-end:10px; border-top:3px solid; border-inline-end:3px solid; }
  .corner-br{ bottom:10px; inset-inline-start:10px; border-bottom:3px solid; border-inline-start:3px solid; }
  .ruler{ background-image:repeating-linear-gradient(to bottom, var(--line) 0 1px, transparent 1px 14px); }
  .reveal{ opacity:0; transform:translateY(30px); transition:opacity 1.3s cubic-bezier(.16,.7,.24,1), transform 1.3s cubic-bezier(.16,.7,.24,1); will-change:opacity, transform; }
  .reveal.is-visible{ opacity:1; transform:translateY(0); }
  .reveal-delay-1.is-visible{ transition-delay:.25s; }
  .reveal-delay-2.is-visible{ transition-delay:.55s; }
  .reveal-delay-3.is-visible{ transition-delay:.85s; }
  .services-reveal,.why-reveal,.generic-reveal{ opacity:0; transform:translateY(24px); transition:opacity .7s ease, transform .7s cubic-bezier(.2,.8,.2,1); }
  .services-reveal.is-visible,.why-reveal.is-visible,.generic-reveal.visible{ opacity:1; transform:translateY(0); }
  .section-title-underline{ width:70px; height:4px; background:linear-gradient(to left, var(--gold), var(--gold-dark)); border-radius:999px; }
  .card-hover{ transition:transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease; }
  .card-hover:hover{ transform:translateY(-6px); box-shadow:0 22px 40px -22px rgba(82,105,112,.35); border-color:rgba(245,173,42,.5); }
  .icon-wrap{ width:64px; height:64px; border-radius:20px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg, rgba(245,173,42,.12), rgba(245,173,42,.04)); color:var(--gold-dark); transition:transform .4s ease, background .4s ease, color .4s ease; overflow:hidden; }
  .icon-wrap img{ width:100%; height:100%; object-fit:cover; border-radius:20px; }
  .card-hover:hover .icon-wrap{ transform:scale(1.08) rotate(-4deg); }
  .deco-corner{ position:absolute; width:60px; height:60px; border:3px solid var(--gold); opacity:.5; }
  .project-img{ transition:transform .7s cubic-bezier(.2,.8,.2,1); }
  .card-hover:hover .project-img{ transform:scale(1.08); }
  .project-overlay{ opacity:0; transition:opacity .4s ease; }
  .project-card:hover .project-overlay{ opacity:1; }
  .line-clamp-2{ display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
  .field{ width:100%; background:var(--bg-soft); border:1px solid #e5e7eb; border-radius:14px; padding:.85rem 1rem; font-size:.95rem; color:var(--teal-dark); outline:none; transition:border-color .25s ease, box-shadow .25s ease, background .25s ease; }
  .field::placeholder{ color:#9ca3af; }
  .field:focus{ border-color:var(--gold); background:#fff; box-shadow:0 0 0 4px rgba(245,173,42,.15); }
  .toast-success{ position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999; }
  .faq-chevron{ transition:transform .3s ease; }
  .faq-chevron.open{ transform:rotate(180deg); }
</style>
