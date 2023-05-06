if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/swreg.js');
  });
}
// Request permission for push notifications
messaging.requestPermission()
  .then(function() {
    console.log('Notification permission granted.');
    // TODO: Save token to server
  })
  .catch(function(err) {
    console.log('Unable to get permission to notify.', err);
  });
const firebaseConfig = {
  apiKey: "AIzaSyDQ_w7NbO-I9O2-tkGbbja6rkO1IYvBewA",
  authDomain: "young-dreamers-for-talaigua.firebaseapp.com",
  projectId: "young-dreamers-for-talaigua",
  storageBucket: "young-dreamers-for-talaigua.appspot.com",
  messagingSenderId: "283442209810",
  appId: "1:283442209810:web:c03492d12872dfe7a324cb",
  measurementId: "G-C8N5445VR6"
};


  firebase.initializeApp(firebaseConfig);
  
  const messaging = firebase.messaging();
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.21.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.21.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyDQ_w7NbO-I9O2-tkGbbja6rkO1IYvBewA",
    authDomain: "young-dreamers-for-talaigua.firebaseapp.com",
    projectId: "young-dreamers-for-talaigua",
    storageBucket: "young-dreamers-for-talaigua.appspot.com",
    messagingSenderId: "283442209810",
    appId: "1:283442209810:web:c03492d12872dfe7a324cb",
    measurementId: "G-C8N5445VR6"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);

  const subscribeButton = document.getElementById('subscribeButton');

subscribeButton.addEventListener('click', async () => {
  try {
    if ('Notification' in window) {
      // Request permission to show notifications
      if (Notification.permission !== 'granted') {
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
          if ('firebase' in window && 'messaging' in firebase) {
            // Get the registration token
            const currentToken = await firebase.messaging().getToken({
              vapidKey: 'BMgLIPeLwMZY1JHxMoxR8CMGEsdz0VkwAz6I7mFLtd3WS9c8ky0nv6GhO0njeR-GY8ES_p5B9QJo3OPZzhVb-Es',
              serviceWorkerRegistration: navigator.serviceWorker.getRegistration()
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
        if ('firebase' in window && 'messaging' in firebase) {
          // Get the registration token
          const currentToken = await firebase.messaging().getToken({
            vapidKey: 'BMgLIPeLwMZY1JHxMoxR8CMGEsdz0VkwAz6I7mFLtd3WS9c8ky0nv6GhO0njeR-GY8ES_p5B9QJo3OPZzhVb-Es',
            serviceWorkerRegistration: navigator.serviceWorker.getRegistration()
          });
          console.log('Token:', currentToken);
        } else {
          console.log('Firebase Messaging is not available');
        }
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
