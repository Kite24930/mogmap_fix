import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";

const firebaseConfig = {
    apiKey: "AIzaSyBMkY2aB3g-6_xLG-rI5AJRQkjqTg4HMRM",
    authDomain: "mogmap-kichencar.firebaseapp.com",
    projectId: "mogmap-kichencar",
    storageBucket: "mogmap-kichencar.appspot.com",
    messagingSenderId: "291652608645",
    appId: "1:291652608645:web:ab19bec56efe5cebe83fec",
    measurementId: "G-5Y30TDG7FM"
};

const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

export { app, analytics };
