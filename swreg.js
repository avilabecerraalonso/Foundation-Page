// Define the cache name and files to cache
const CACHE_NAME = 'jspt-v03';
const urlsToCache = [
  '/',
  '/index.php',
  '/assets/css/main.css',
  '/assets/js/app.js'
];

// Install the service worker and cache files
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then((cache) => cache.addAll(urlsToCache))
  );
});

// Serve cached files or fetch new ones
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        if (response) {
          return response;
        }

        return fetch(event.request)
          .then((response) => {
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            const responseToCache = response.clone();

            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(event.request, responseToCache);
              });

            return response;
          });
      })
  );
});

// Delete old caches when the cache name changes
self.addEventListener('activate', (event) => {
  const cacheWhitelist = [CACHE_NAME];

  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (!cacheWhitelist.includes(cacheName)) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

// Initialize Firebase
importScripts('https://www.gstatic.com/firebasejs/9.0.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.1/firebase-messaging-compat.js');

try {
  firebase.initializeApp({
    apiKey: "AIzaSyDQ_w7NbO-I9O2-tkGbbja6rkO1IYvBewA",
    authDomain: "young-dreamers-for-talaigua.firebaseapp.com",
    projectId: "young-dreamers-for-talaigua",
    storageBucket: "young-dreamers-for-talaigua.appspot.com",
    messagingSenderId: "283442209810",
    appId: "1:283442209810:web:c03492d12872dfe7a324cb",
    measurementId: "G-C8N5445VR6"
  });
} catch (error) {
  console.log('Error initializing Firebase:', error);
}

// Request permission to show notifications and subscribe the user
self.addEventListener('activate', async () => {
  try {
    if ('Notification' in self) {
      // Request permission to show notifications
      const permission = await Notification.requestPermission();
      if (permission === 'granted') {
        if ('firebase' in self && 'messaging' in firebase) {
          // Get the registration token
          const currentToken = await firebase.messaging().getToken({
            vapidKey: 'BMgLIPeLwMZY1JHxMoxR8CMGEsdz0VkwAz6I7mFLtd3WS9c8ky0nv6GhO0njeR-GY8ES_p5B9QJo3OPZzhVb-Es',
            serviceWorkerRegistration: self.registration
          });
          console.log('Token:', currentToken);
        } else {
          console.log('Firebase Messaging is not available');
        }
      } else if (permission === 'denied') {
        console.log('Permission for notifications was denied');
      } else if (permission === 'default') {
        console.log('The permission request was dismissed by the user');
      }
    } else {
      console.log('Notifications are not available');
    }
  } catch (error) {
    if (error.code === 'messaging/permission-blocked') {
      console.log('The permission for notifications was blocked');
    } else {
      console.log('Error while subscribing to notifications:', error);
    }
  }
});

// Handle incoming messages
if ('firebase' in self && 'messaging' in firebase) {
  firebase.messaging().onBackgroundMessage((payload) => {
    console.log('[Service Worker] Received background message ', payload);

    const { title, body, icon } = payload.notification;

    self.registration.showNotification(title, {
      body,
      icon,
    });
  });
} else {
  console.log('Firebase Messaging is not available');
}

// Handle notification clicks
self.addEventListener('notificationclick', (event) => {
  console.log('[Service Worker] Notification click Received.');

  event.notification.close();

  event.waitUntil(clients.openWindow('https://youngdreamersfortalaigua.org'));
});
