import '../common.js';
import { getAuth, onAuthStateChanged, updateEmail, EmailAuthProvider, reauthenticateWithCredential } from "firebase/auth";
import axios from "axios";

window.addEventListener('load', init);
const contentsContainer = document.getElementById('contentsContainer');
const userName = document.getElementById('userName');
const userEmail = document.getElementById('userEmail');

function init() {
    const loading = document.getElementById('loading');
    onAuthStateChanged(getAuth(), user => {
        if (user) {
            console.log('ログインしています。');
            const token = document.getElementsByName('_token')[0].value;
            const uid = user.uid;
            axios.post('/api/accountVerification', { uid: uid, _token: token })
                .then(res => {
                    // console.log(res.data);
                    if (res.data.status === 'ok') {
                        userName.textContent = res.data.user_name;
                        userEmail.textContent = user.email;
                        document.getElementById('nameChangeBtn').addEventListener('click', () => {
                            updateName(user, token);
                        });
                        document.getElementById('emailChangeBtn').addEventListener('click', () => {
                            updateEmailMethod(user, token);
                        });
                    }
                    loading.style.opacity = 0;
                    setTimeout(() => {
                        loading.style.display = 'none';
                    }, 500)
                })
                .catch(err => {
                    console.log(err);
                });
        } else {
            console.log('ログアウトしています。');
            window.alert('このページは会員専用ページです。\nトップページに移動します。');
            window.location.href = '/';
        }
    })
}

function updateName(user, token) {
    const name = document.getElementById('accountName');
    axios.post('/api/account/name', {
        user_name: name.value,
        user_id: user.uid,
        _token: token,
    })
        .then(res => {
            if (res.data.msg === 'ok') {
                userName.textContent = name.value;
                window.alert('ユーザー名を変更しました。');
                name.value = '';
            } else {
                window.alert('ユーザー名の変更に失敗しました。');
            }
        })
        .catch(err => {
            console.log(err);
            window.alert('ユーザー名の変更に失敗しました。');
        });
}

function updateEmailMethod(user) {
    const email = document.getElementById('accountEmail');
    const confirmEmail = document.getElementById('confirmEmail');
    const password = document.getElementById('password');
    if (email.value !== confirmEmail.value) {
        window.alert('メールアドレスが一致しません。');
        return;
    }
    if (password.value === '') {
        window.alert('パスワードを入力してください。');
        return;
    }
    const credential = EmailAuthProvider.credential(user.email, password.value);
    reauthenticateWithCredential(user, credential)
        .then(() => {
            updateEmail(user, email.value)
                .then(() => {
                    window.alert('メールアドレスを変更しました。');
                    userEmail.textContent = email.value;
                    email.value = '';
                    confirmEmail.value = '';
                    password.value = '';
                })
                .catch(err => {
                    console.log(err);
                    window.alert('メールアドレスの変更に失敗しました。');
                });
        })
        .catch(err => {
            console.log(err);
            window.alert('メールアドレスの変更に失敗しました。');
        });
}
