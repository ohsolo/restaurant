import firebase from 'firebase';

const firebaseConfig = {
  apiKey: "AIzaSyBvXuoL8aGrtK6RxGy_-HvGwKf6ViVynm4",
  authDomain: "litoral-app.firebaseapp.com",
  projectId: "litoral-app",
  storageBucket: "litoral-app.appspot.com",
  messagingSenderId: "812829709902",
  appId: "1:812829709902:web:02fd301307745cbdb9951f"
};

firebase.initializeApp(firebaseConfig);

export default firebase;
