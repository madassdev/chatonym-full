importScripts('https://www.gstatic.com/firebasejs/7.16.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.16.0/firebase-messaging.js');
var firebaseConfig = {
    apiKey: "AIzaSyBYtoMYgqcD0xJA67rfD2ZI4jV-DGhBx84",
    authDomain: "chatonym-full.firebaseapp.com",
    projectId: "chatonym-full",
    storageBucket: "chatonym-full.appspot.com",
    messagingSenderId: "738168635297",
    appId: "1:738168635297:web:3e033097bd626e9d4bd5e0",
    measurementId: "G-82GPCTJ8SG"
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

