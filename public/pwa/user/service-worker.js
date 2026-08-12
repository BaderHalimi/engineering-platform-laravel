const CACHE_NAME = 'employee-panel-assets-v1';
const STATIC_ASSETS = [
    '/user-manifest.webmanifest',
    '/pwa/icons/employee-192.png',
    '/pwa/icons/employee-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_ASSETS)));
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((keys) => Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))))
            .then(() => self.clients.claim())
    );
});

// صفحات وطلبات لوحة الموظفين تبقى من الشبكة ولا تُحفظ، حمايةً للبيانات والحسابات.
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);
    if (event.request.method !== 'GET' || url.origin !== self.location.origin || !STATIC_ASSETS.includes(url.pathname)) return;

    event.respondWith(caches.match(event.request).then((cached) => cached || fetch(event.request)));
});
