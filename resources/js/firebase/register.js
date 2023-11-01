import '../common.js';
import { getAuth, onAuthStateChanged, createUserWithEmailAndPassword } from "firebase/auth";
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

const userName = document.getElementById('user_name');
const email = document.getElementById('email');
const password = document.getElementById('password');
const passwordConfirm = document.getElementById('password_confirm');
const registerButton = document.getElementById('register_button');
const auth = getAuth();

registerButton.addEventListener('click', () => {
    if (userName.value === '') {
        window.alert('ユーザー名を入力してください。');
        return;
    }
    if (email.value === '') {
        window.alert('メールアドレスを入力してください。');
        return;
    }
    if (password.value === '') {
        window.alert('パスワードを入力してください。');
        return;
    }
    if (password.value !== passwordConfirm.value) {
        window.alert('パスワードが一致しません。');
        return;
    }
    createUserWithEmailAndPassword(auth, email.value, password.value)
        .then((userCredential) => {
            const user = userCredential.user;
            axios.post('/api/user/register', {
                user_name: userName.value,
                uid: user.uid,
            })
                .then(res => {
                    if (res.data.msg === 'ok') {
                        window.alert('会員登録が完了しました。');
                        window.location.href = '/mypage';
                    } else {
                        window.alert('会員登録に失敗しました。');
                    }
                })
                .catch(err => {
                    window.alert('会員登録に失敗しました。');
                    console.log(err);
                })
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            window.alert(errorMessage);
        });
})
