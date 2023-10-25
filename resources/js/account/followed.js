import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";

function init() {
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
    onAuthStateChanged(getAuth(), user => {
        if (user) {
            console.log('ログインしています。');
        } else {
            console.log('ログアウトしています。');
        }
    })
}
