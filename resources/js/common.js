import './app.js';
import { app, analytics } from "./module/firebase.js";
import 'flowbite';
import { getAuth, onAuthStateChanged, signInWithEmailAndPassword, signOut } from "firebase/auth";

window.addEventListener('load', init);
const loading = document.getElementById('loading');
const loginBtn = document.querySelectorAll('.login-btn');
const spLoginBtn = document.getElementById('spLoginBtn');
const pcLoginBtn = document.getElementById('pcLoginBtn');
const spLogin = document.getElementById('spLogin');
const pcLogin = document.getElementById('pcLogin');
const myPageBtn = document.createElement('a');
myPageBtn.href = '/mypage';
myPageBtn.classList.add('block', 'w-full', 'px-4', 'py-2', 'border-b', 'border-gray-200', 'cursor-pointer', 'hover:bg-gray-100', 'hover:text-blue-700', 'focus:outline-none', 'focus:ring-blue-700', 'focus:ring-2');
myPageBtn.innerHTML = '<i class="bi bi-person-circle mr-2"></i>マイページ';
const logoutBtn = document.createElement('button');
logoutBtn.type = 'button';
logoutBtn.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'my-2', 'bg-gray-800', 'border', 'border-transparent', 'rounded-md', 'font-semibold', 'text-xs', 'text-white', 'uppercase', 'tracking-widest', 'hover:bg-gray-700', 'focus:bg-gray-700', 'active:bg-gray-900', 'focus:outline-none', 'focus:border-gray-900', 'focus:ring-2', 'focus:ring-indigo-500', 'focus:ring-offset-2', 'transition', 'ease-in-out', 'duration-150', 'logout-btn');
logoutBtn.innerHTML = '<i class="bi bi-door-closed mr-2 text-white"></i>ログアウト';
const followListBtn = document.createElement('a');
followListBtn.href = '/followed';
followListBtn.classList.add('block', 'w-full', 'px-4', 'py-2', 'border-b', 'border-gray-200', 'cursor-pointer', 'hover:bg-gray-100', 'hover:text-blue-700', 'focus:outline-none', 'focus:ring-blue-700', 'focus:ring-2');
followListBtn.innerHTML = '<i class="bi bi-arrow-through-heart mr-2"></i>フォローリスト';
const emailLabel = document.createElement('label');
emailLabel.classList.add('block', 'text-sm', 'font-medium', 'text-gray-700');
emailLabel.textContent = 'Email';
const emailInput = document.createElement('input');
emailInput.type = 'email';
emailInput.classList.add('w-full', 'text-sm', 'border-gray-300', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'rounded-md', 'shadow-sm');
const passwordLabel = document.createElement('label');
passwordLabel.classList.add('block', 'mt-4', 'text-sm', 'font-medium', 'text-gray-700');
passwordLabel.textContent = 'Password';
const passwordInput = document.createElement('input');
passwordInput.type = 'password';
passwordInput.classList.add('w-full', 'text-sm', 'border-gray-300', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'rounded-md', 'shadow-sm');
const loginContainer = document.createElement('div');
loginContainer.classList.add('flex', 'justify-center', 'items-center', 'py-2');
const loginButton = document.createElement('button');
loginButton.type = 'button';
loginButton.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'bg-gray-800', 'border', 'border-transparent', 'rounded-md', 'font-semibold', 'text-xs', 'text-white', 'uppercase', 'tracking-widest', 'hover:bg-gray-700', 'focus:bg-gray-700', 'active:bg-gray-900', 'focus:outline-none', 'focus:ring-2', 'focus-ring-indigo-500', 'focus:ring-offset-2', 'transition', 'ease-in-out', 'duration-150', 'login-btn');
loginButton.textContent = 'ログイン';
const registerContainer = document.createElement('div');
registerContainer.classList.add('flex', 'flex-col', 'justify-center', 'items-center', 'py-2', 'gap-3');
const passwordResetLink = document.createElement('a');
passwordResetLink.href = '/password/reset';
passwordResetLink.textContent = 'パスワードを忘れた方はこちら';
passwordResetLink.classList.add('underline');
const registerLink = document.createElement('a');
registerLink.href = '/register';
registerLink.textContent = '新規登録はこちら';
registerLink.classList.add('underline');
const loadSpinContainer = document.createElement('div');
loadSpinContainer.classList.add('spin-load-wrapper', 'w-full', 'h-full', 'flex', 'justify-center', 'items-center');
const loadSpin = document.createElement('div');
loadSpin.classList.add('spin-load', 'text-pink-500');

function init() {
    const auth = getAuth();
    onAuthStateChanged(auth, (user) => {
        if (user) {
            spLogin.innerHTML = '';
            pcLogin.innerHTML = '';
            spLogin.classList.add('flex', 'flex-col', 'items-center', 'justify-center');
            pcLogin.classList.add('flex', 'flex-col', 'items-center', 'justify-center');
            spLogin.appendChild(myPageBtn.cloneNode(true));
            pcLogin.appendChild(myPageBtn.cloneNode(true));
            spLogin.appendChild(followListBtn.cloneNode(true));
            pcLogin.appendChild(followListBtn.cloneNode(true));
            const spLogoutBtn = logoutBtn.cloneNode(true);
            const pcLogoutBtn = logoutBtn.cloneNode(true);
            spLogoutBtn.addEventListener('click', mailAndPassLogout);
            pcLogoutBtn.addEventListener('click', mailAndPassLogout);
            spLogin.appendChild(spLogoutBtn);
            pcLogin.appendChild(pcLogoutBtn);
            spLoginBtn.innerHTML = '<i class="bi bi-person-hearts text-pink-500 text-2xl"></i>';
            pcLoginBtn.classList.add('text-pink-500');
            pcLoginBtn.innerHTML = '<i class="bi bi-person-hearts mr-2 text-pink-500"></i>ログイン中';
        } else {
            loginBtn.forEach(el => {
                el.addEventListener('click', (e) => {
                    const emailEl = el.getAttribute('data-target-email');
                    const passwordEl = el.getAttribute('data-target-password');
                    const email = document.getElementById(emailEl).value;
                    const password = document.getElementById(passwordEl).value;
                    mailAndPassLogin(email, password);
                });
            })
            spLoginBtn.innerHTML = '<i class="bi bi-person-fill text-2xl"></i>';
            pcLoginBtn.classList.remove('text-pink-500');
            pcLoginBtn.innerHTML = '<i class="bi bi-person-fill mr-2"></i>ログイン/新規登録';
            spLogin.innerHTML = '';
            spLogin.classList.remove('flex', 'items-center', 'justify-center')
            const spEmailLabel = emailLabel.cloneNode(true);
            spEmailLabel.setAttribute('for', 'spLoginEmail');
            const spEmailInput = emailInput.cloneNode(true);
            spEmailInput.id = 'spLoginEmail';
            const spPasswordLabel = passwordLabel.cloneNode(true);
            spPasswordLabel.setAttribute('for', 'spLoginPassword');
            const spPasswordInput = passwordInput.cloneNode(true);
            spPasswordInput.id = 'spLoginPassword';
            const spLoginContainer = loginContainer.cloneNode(true);
            const spLoginButton = loginButton.cloneNode(true);
            spLoginButton.addEventListener('click', () => {
                const email = document.getElementById('spLoginEmail').value;
                const password = document.getElementById('spLoginPassword').value;
                mailAndPassLogin(email, password);
            });
            spLoginContainer.appendChild(spLoginButton);
            const spRegisterContainer = registerContainer.cloneNode(true);
            const spPasswordResetLink = passwordResetLink.cloneNode(true);
            const spRegisterLink = registerLink.cloneNode(true);
            spRegisterContainer.appendChild(spPasswordResetLink);
            spRegisterContainer.appendChild(spRegisterLink);
            spLogin.appendChild(spEmailLabel);
            spLogin.appendChild(spEmailInput);
            spLogin.appendChild(spPasswordLabel);
            spLogin.appendChild(spPasswordInput);
            spLogin.appendChild(spLoginContainer);
            spLogin.appendChild(spRegisterContainer);
            pcLogin.innerHTML = '';
            pcLogin.classList.remove('flex', 'items-center', 'justify-center')
            const pcEmailLabel = emailLabel.cloneNode(true);
            pcEmailLabel.setAttribute('for', 'pcLoginEmail');
            const pcEmailInput = emailInput.cloneNode(true);
            pcEmailInput.id = 'pcLoginEmail';
            const pcPasswordLabel = passwordLabel.cloneNode(true);
            pcPasswordLabel.setAttribute('for', 'pcLoginPassword');
            const pcPasswordInput = passwordInput.cloneNode(true);
            pcPasswordInput.id = 'pcLoginPassword';
            const pcLoginContainer = loginContainer.cloneNode(true);
            const pcLoginButton = loginButton.cloneNode(true);
            pcLoginButton.addEventListener('click', () => {
                const email = document.getElementById('pcLoginEmail').value;
                const password = document.getElementById('pcLoginPassword').value;
                mailAndPassLogin(email, password);
            });
            pcLoginContainer.appendChild(pcLoginButton);
            const pcRegisterContainer = registerContainer.cloneNode(true);
            const pcPasswordResetLink = passwordResetLink.cloneNode(true);
            const pcRegisterLink = registerLink.cloneNode(true);
            pcRegisterContainer.appendChild(pcPasswordResetLink);
            pcRegisterContainer.appendChild(pcRegisterLink);
            pcLogin.appendChild(pcEmailLabel);
            pcLogin.appendChild(pcEmailInput);
            pcLogin.appendChild(pcPasswordLabel);
            pcLogin.appendChild(pcPasswordInput);
            pcLogin.appendChild(pcLoginContainer);
            pcLogin.appendChild(pcRegisterContainer);
        }
    });

}


function mailAndPassLogin(email, password) {
    const auth = getAuth();
    signInWithEmailAndPassword(auth, email, password).then((userCredential) => {
        window.alert('ログインが正常に完了しました');
        init();
    }).catch((error) => {
        console.log(error);
        window.alert('ログインに失敗しました\n入力内容を確認してください');
    })
}

function mailAndPassLogout() {
    const auth = getAuth();
    signOut(auth).then(() => {
        window.alert('ログアウトしました');
        init();
    }).catch((error) => {
        console.log(error);
        window.alert('ログアウトに失敗しました');
    });
}

export { mailAndPassLogin, mailAndPassLogout };
