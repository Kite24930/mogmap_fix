import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import axios from "axios";

window.addEventListener('load', init);
const contentsContainer = document.getElementById('contentsContainer');

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
                        document.getElementById('userName').textContent = res.data.user_name;
                        const email = user.email.split('@');
                        document.getElementById('userEmail').textContent = email[0].slice(0, 3) + '****@' + email[1].slice(0, 3) + '****';
                        if (typeof res.data.shops !== 'undefined') {
                            res.data.shops.forEach(shop => {
                                const shopContainer = document.createElement('div');
                                shopContainer.classList.add('shopContainer', 'w-full', 'max-w-sm', 'p-4', 'bg-white', 'border', 'border-green-300', 'rounded-lg', 'flex', 'flex-col', 'items-center', 'mb-4');
                                const shopName = document.createElement('p');
                                shopName.classList.add('shopName', 'text-lg', 'font-bold', 'text-center', 'mb-2');
                                shopName.textContent = shop.shop_name;
                                const shopItemContainer = document.createElement('div');
                                shopItemContainer.classList.add('shopItemContainer', 'w-full', 'flex', 'items-center');
                                const shopImgContainer = document.createElement('div');
                                shopImgContainer.classList.add('shopImgContainer', 'w-1/2', 'square');
                                const shopImg = document.createElement('img');
                                shopImg.classList.add('rounded-lg', 'border');
                                shopImg.src = 'storage/shop/' + shop.shop_img;
                                shopImgContainer.appendChild(shopImg);
                                const shopItemInfoContainer = document.createElement('div');
                                shopItemInfoContainer.classList.add('shopItemInfoContainer', 'w-1/2', 'flex', 'flex-col', 'items-center', 'justify-center', 'gap-4');
                                const shopPageLink = document.createElement('a');
                                shopPageLink.classList.add('shopPageLink', 'px-4', 'py-2', 'text-sm', 'bg-yellow-100', 'rounded', 'border', 'border-yellow-500', 'text-yellow-500', 'hover:bg-yellow-500', 'hover:text-yellow-100', 'hover:border-yellow-100', 'transition', 'duration-300');
                                shopPageLink.href = '/shop/' + shop.id + '/' + shop.shop_name;
                                shopPageLink.textContent = 'ショップページへ';
                                const shopInfoLink = document.createElement('a');
                                shopInfoLink.classList.add('shopInfoLink', 'px-4', 'py-2', 'text-sm', 'bg-blue-100', 'rounded', 'border', 'border-blue-500', 'text-blue-500', 'hover:bg-blue-500', 'hover:text-blue-100', 'hover:border-blue-100', 'transition', 'duration-300');
                                shopInfoLink.href = '/shop/edit/' + shop.id;
                                shopInfoLink.textContent = '登録情報編集';
                                const shopSetUpLink = document.createElement('a');
                                shopSetUpLink.classList.add('shopOpenLink', 'px-4', 'py-2', 'text-sm', 'bg-pink-100', 'rounded', 'border', 'border-pink-500', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100', 'hover:border-pink-100', 'transition', 'duration-300');
                                shopSetUpLink.href = '/shop/setup/' + shop.id;
                                shopSetUpLink.textContent = '出店情報編集';
                                shopItemInfoContainer.appendChild(shopPageLink);
                                shopItemInfoContainer.appendChild(shopInfoLink);
                                shopItemInfoContainer.appendChild(shopSetUpLink);
                                shopItemContainer.appendChild(shopImgContainer);
                                shopItemContainer.appendChild(shopItemInfoContainer);
                                shopContainer.appendChild(shopName);
                                shopContainer.appendChild(shopItemContainer);
                                contentsContainer.appendChild(shopContainer);
                            });
                        }
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
