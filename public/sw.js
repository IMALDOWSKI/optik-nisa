const CACHE_NAME = 'optik-nisa-v1';
const urlsToCache = [
    '/manifest.json',
    '/icons/launchericon-192x192.png',
    '/icons/launchericon-512x512.png',
];

// Install service worker & cache asset penting
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(urlsToCache);
        })
    );
});

// Bersihkan cache lama saat ada versi baru
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Strategi: network first, fallback ke cache kalau offline
self.addEventListener('fetch', (event) => {
    // Skip untuk request non-GET (POST, PUT, DELETE) - biarkan langsung ke server
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                return response;
            })
            .catch(() => {
                return caches.match(event.request);
            })
    );
});