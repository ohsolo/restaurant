importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js');

	firebase.initializeApp({
        apiKey: "AIzaSyBvXuoL8aGrtK6RxGy_-HvGwKf6ViVynm4",
        authDomain: "litoral-app.firebaseapp.com",
        projectId: "litoral-app",
        storageBucket: "litoral-app.appspot.com",
        messagingSenderId: "812829709902",
        appId: "1:812829709902:web:02fd301307745cbdb9951f"
    });

	const messaging = firebase.messaging();
    messaging.setBackgroundMessageHandler(function(payload) {
        const noteTitle = payload.data.title;
        const noteOptions = {
            body: payload.data.body,
            icon: payload.data.icon,
            data: payload.data
        };

        return self.registration.showNotification(noteTitle,
            noteOptions);
    });
    self.addEventListener('notificationclick', function(event) {
        // var newUrl =  'https://discoveritech.org/staff-dashboard/connect-to-app' + '?room_name=' + event.notification.data.room_name;
        // clients.openWindow(newUrl);
    });