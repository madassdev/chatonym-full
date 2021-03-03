importScripts('https://www.gstatic.com/firebasejs/7.16.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.16.0/firebase-messaging.js');
const firebaseConfig = {
    apiKey: "AIzaSyCzzLQxYlhGrME1pB5Ukie2eZysQ014BpU",
    authDomain: "autifycloud-bba94.firebaseapp.com",
    databaseURL: "https://autifycloud-bba94.firebaseio.com",
    projectId: "autifycloud-bba94",
    storageBucket: "autifycloud-bba94.appspot.com",
    messagingSenderId: "338960353893",
    appId: "1:338960353893:web:e082eb524607ac7839d48c",
    measurementId: "G-ECGLNDB5YY"
  };

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
