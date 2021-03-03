var firebaseConfig = {
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
var messaging = firebase.messaging();
messaging.usePublicVapidKey('BIgOJWFRsxd_BXdrOcciZBdQII-IImiQyrtIe24vEAIKpbvXfsZc-MnywceM2_vCGqSTOURapO2UnaW26CQ3U9Q');
messaging.requestPermission().then(function () {
    console.log("Notification permission granted.");
    return messaging.getToken();
}).then(function (token) {
    console.log(token);
    //alert(token);
})["catch"](function (err) {
    console.log("Unable to get permission to notify.", err);
});

messaging.onMessage(function (payload) {
    console.log('onMessage: ', payload);
    alert('message recieved!');
});
