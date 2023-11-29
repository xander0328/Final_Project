// src/firebase.js
import {initializeApp} from 'firebase/app';
import {getStorage} from 'firebase/storage';

const firebaseConfig = {
  apiKey: "AIzaSyCN2z9SUjeFwuwAioj3Aog5B2F9aYQmNsE",
  authDomain: "serious-mariner-406602.firebaseapp.com",
  projectId: "serious-mariner-406602",
  storageBucket: "serious-mariner-406602.appspot.com",
  messagingSenderId: "756646228293",
  appId: "1:756646228293:web:7ca1126bbaf47126138e2c",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

// Export Firebase storage
const storage = getStorage(app);
export { storage };
