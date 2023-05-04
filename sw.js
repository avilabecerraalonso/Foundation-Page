// Define the cache name
const CACHE_NAME = 'fjspt-cachev1.0';

// Define the files to cache
const urlsToCache = [
  '/assets/css/main.css',
  '/assets/js/main.js'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
      .catch(err => console.error('Error recolectando archivos:', err))
  );
});

self.addEventListener('fetch', event => {
  // Exclude the login page and related requests from being cached
  if (event.request.url.includes('/') || event.request.url.includes('/index') || event.request.url.includes('/account') || event.request.url.includes('/dashboard')) {
    return fetch(event.request);
  }

  event.respondWith(
    caches.match(event.request)
      .then(response => {
        if (response) {
          return response;
        }

        const fetchRequest = event.request.clone();

        return fetch(fetchRequest, { credentials: 'omit' })
          .then(response => {
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            const responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then(cache => {
                cache.put(event.request, responseToCache);
              });

            return response;
          });
      })
      .catch(err => console.error('Error con los archivos del caché:', err))
  );
});

// Delete old caches
self.addEventListener('activate', event => {
  const cacheWhitelist = [CACHE_NAME];

  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
    .catch(err => console.error('Error eliminando caché antiguo:', err))
  );
});
