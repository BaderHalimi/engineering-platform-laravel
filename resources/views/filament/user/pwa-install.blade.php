<div id="employee-pwa-install" hidden dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
     style="position:fixed;inset-inline-end:1rem;bottom:1rem;z-index:1000;max-width:22rem;padding:1rem;border-radius:1rem;background:#fff;color:#111827;box-shadow:0 12px 35px rgba(0,0,0,.2);border:1px solid #e5e7eb">
    <div style="display:flex;align-items:center;gap:.75rem">
        <img src="{{ asset('pwa/icons/employee-192.png') }}" alt="" width="48" height="48" style="border-radius:.75rem">
        <div style="flex:1">
            <strong style="display:block">{{ app()->getLocale() === 'ar' ? 'ثبّت لوحة الموظفين' : 'Install employee panel' }}</strong>
            <small style="color:#6b7280">{{ app()->getLocale() === 'ar' ? 'وصول أسرع من الشاشة الرئيسية' : 'Quick access from your home screen' }}</small>
            <small data-ios-help hidden style="display:block;margin-top:.25rem;color:#92400e">{{ app()->getLocale() === 'ar' ? 'من زر المشاركة اختر «إضافة إلى الشاشة الرئيسية»' : 'From Share, choose “Add to Home Screen”' }}</small>
        </div>
        <button type="button" data-pwa-dismiss aria-label="{{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}" style="padding:.25rem;background:none;border:0;cursor:pointer;font-size:1.25rem">×</button>
    </div>
    <button type="button" data-pwa-install style="width:100%;margin-top:.75rem;padding:.65rem 1rem;border:0;border-radius:.65rem;background:#d97706;color:#fff;font-weight:700;cursor:pointer">
        {{ app()->getLocale() === 'ar' ? 'تثبيت التطبيق' : 'Install app' }}
    </button>
</div>

<script>
    (() => {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => navigator.serviceWorker.register('{{ url('/pwa/user/service-worker.js') }}', { scope: '/user/' }).catch(() => {}));
        }

        const box = document.getElementById('employee-pwa-install');
        const iosHelp = box?.querySelector('[data-ios-help]');
        const isIos = /iphone|ipad|ipod/i.test(navigator.userAgent);
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone === true;
        let installPrompt;

        if (isIos && !isStandalone && localStorage.getItem('employee-pwa-dismissed') !== '1') {
            box.hidden = false;
            iosHelp.hidden = false;
        }

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            installPrompt = event;
            if (localStorage.getItem('employee-pwa-dismissed') !== '1') box.hidden = false;
        });

        box?.querySelector('[data-pwa-install]')?.addEventListener('click', async () => {
            if (!installPrompt) {
                if (isIos) iosHelp.hidden = false;
                return;
            }
            await installPrompt.prompt();
            await installPrompt.userChoice;
            installPrompt = null;
            box.hidden = true;
        });

        box?.querySelector('[data-pwa-dismiss]')?.addEventListener('click', () => {
            box.hidden = true;
            localStorage.setItem('employee-pwa-dismissed', '1');
        });

        window.addEventListener('appinstalled', () => { box.hidden = true; });
    })();
</script>
