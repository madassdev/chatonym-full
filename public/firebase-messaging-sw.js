importScripts("https://www.gstatic.com/firebasejs/7.16.0/firebase-app.js");
importScripts(
    "https://www.gstatic.com/firebasejs/7.16.0/firebase-messaging.js"
);
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

messaging.setBackgroundMessageHandler(function(payload) {
    // storeMessage(payload);
    // Customize notification here

    const notificationTitle = payload.data.title;
    const notificationOptions = {
        title:payload.data.title,
        body: payload.data.body,
        icon: "/firebase-logo.png",
        click_action: 'https://facebook.com'
    };

    return self.registration.showNotification(
        notificationTitle,
        notificationOptions
    );
});

// function storeMessage(payload) {
//     var chats = [
//         {
//             message: "Who are you?",
//             created_at: Date.now(),
//             is_sender: 1,
//             mesasge_id: 123,
//             recipient_token: "gibberishly-long-token"
//         },
//         {
//             message: "You can't know uhh",
//             created_at: Date.now(),
//             is_sender: 0,
//             mesasge_id: 123,
//             recipient_token: "gibberishly-long-token"
//         },
//         {
//             message: "Who are you too?",
//             created_at: Date.now(),
//             is_sender: 1,
//             mesasge_id: 126,
//             recipient_token: "second-gibberishly-long-token"
//         }
//     ];
//     console.log("chats before", chats);

//     console.log("Paylaod delivered");
//     const message = JSON.parse(payload.data.message);
//     const new_chat_message = {
//         message: message.id,
//         created_at: message.created_at,
//         recipient_token: message.replier_token,
//         message_id: message.id
//     };

//     chats.push(new_chat_message);
//     console.log("chats after", chats);
//     window.localStorage.setItem('fcm_chats', chats);
// }
