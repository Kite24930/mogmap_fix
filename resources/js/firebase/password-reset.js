import '../common.js';
import { getAuth, sendPasswordResetEmail } from "firebase/auth";
import axios from "axios";

window.addEventListener('load', init);
const contentsContainer = document.getElementById('contentsContainer');

function init() {
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
}

const email = document.getElementById('email');
const send = document.getElementById('send');

send.addEventListener('click', () => {
    const auth = getAuth();
    sendPasswordResetEmail(auth, email.value)
        .then(() => {
            window.alert('パスワードリセットメールを送信しました');
            window.location.href = '/';
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            window.alert('パスワードリセットメールの送信に失敗しました');
        });
})
