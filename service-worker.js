self.addEventListener('install', (event) => {
    event.waitUntil(
      caches.open('mon-cache').then((cache) => {
        return cache.addAll([
          '/',
          '/home.php',
          '/assets/icon.png',
          '/login.php',
          '/dashboard.php',
          '/account.php',
          '/style.css',
        ]);
      })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        return cachedResponse || fetch(event.request);
      })
    );
});
