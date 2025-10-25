const CACHE_NAME = 'formularium-v1.1';
const STATIC_CACHE = 'static-v1.1';
const DYNAMIC_CACHE = 'dynamic-v1.1';

const STATIC_ASSETS = [
  '/',
  '/css/app.css',
  '/js/app.js',
  '/manifest.json',
  '/logo-rsia.png',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css',
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.woff2'
];

// Cache static assets during installation
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(STATIC_CACHE)
      .then(cache => {
        console.log('Caching static assets');
        return cache.addAll(STATIC_ASSETS);
      })
  );
});

// Clean up old caches during activation
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== STATIC_CACHE && cacheName !== DYNAMIC_CACHE) {
            console.log('Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Network first, falling back to cache strategy
self.addEventListener('fetch', event => {
  // Skip non-GET requests
  if (event.request.method !== 'GET') return;

  // Skip Chrome extension requests and other non-http(s) requests
  if (!event.request.url.startsWith('http')) return;

  event.respondWith(
    fetch(event.request)
      .then(response => {
        // Clone the response before using it
        const responseClone = response.clone();
        
        // Open dynamic cache and store the response
        caches.open(DYNAMIC_CACHE)
          .then(cache => {
            cache.put(event.request, responseClone);
          });

        return response;
      })
      .catch(() => {
        // If network fails, try to get from cache
        return caches.match(event.request)
          .then(cachedResponse => {
            if (cachedResponse) {
              return cachedResponse;
            }
            
            // If the request is for an image, return a fallback
            if (event.request.headers.get('accept').includes('image')) {
              return caches.match('/logo-rsia.png');
            }
            
            // Return the offline page for navigation requests
            if (event.request.mode === 'navigate') {
              return caches.match('/');
            }
            
            return new Response('Network error happened', {
              status: 408,
              headers: { 'Content-Type': 'text/plain' }
            });
          });
      })
  );
});