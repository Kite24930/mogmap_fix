import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import axios from "axios";

window.addEventListener('load', init);
const contentsContainer = document.getElementById('contentsContainer');

function init() {
    onAuthStateChanged(getAuth(), user => {
        if (user) {
            console.log('ログインしています。');
            const token = document.getElementsByName('_token')[0].value;
            const uid = user.uid;
            axios.post('/api/followedGet', { uid: uid, _token: token })
                .then(res => {
                    console.log(res.data);
                    if (res.data.status === 'ok') {
                        res.data.followed.forEach(shop => {
                            const shopContainer = document.createElement('div');
                            shopContainer.classList.add('shopContainer', 'bg-yellow-50', 'border', 'border-yellow-300', 'p-4', 'rounded-lg', 'flex', 'flex-col', 'items-center', 'gap-4');
                            const shopName = document.createElement('p');
                            shopName.classList.add('shopName', 'text-lg', 'font-bold');
                            shopName.textContent = shop.shop_name;
                            const shopItemContainer = document.createElement('div');
                            shopItemContainer.classList.add('shopItemContainer', 'flex', 'items-center', 'gap-4');
                            const shopImgContainer = document.createElement('div');
                            shopImgContainer.classList.add('shopImgContainer', 'w-32', 'square');
                            const shopImg = document.createElement('img');
                            shopImg.classList.add('rounded-lg', 'border');
                            shopImg.src = 'storage/shop/' + shop.shop_img;
                            shopImgContainer.appendChild(shopImg);
                            const shopItemInfoContainer = document.createElement('div');
                            shopItemInfoContainer.classList.add('shopItemInfoContainer', 'flex', 'flex-col', 'items-center', 'justify-center', 'gap-4');
                            const shopPageLink = document.createElement('a');
                            shopPageLink.classList.add('shopPageLink', 'px-4', 'py-2', 'text-sm', 'bg-green-100', 'rounded', 'border', 'border-green-500', 'text-green-500', 'hover:bg-green-500', 'hover:text-green-100', 'hover:border-green-100', 'transition', 'duration-300');
                            shopPageLink.href = '/shop/' + shop.shop_id + '/' + shop.shop_name;
                            shopPageLink.textContent = 'ショップページへ';
                            const shopFollowed = document.createElement('div');
                            shopFollowed.classList.add('shopFollowed', 'px-4', 'py-2', 'text-sm', 'bg-pink-100', 'rounded', 'border', 'border-pink-500', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100', 'hover:border-pink-100', 'transition', 'duration-300', 'group');
                            shopFollowed.setAttribute('data-shop-id', shop.id);
                            shopFollowed.innerHTML = '<i class="bi bi-arrow-through-heart mr-2 text-pink-500 group-hover:text-pink-100"></i>フォロー中';
                            shopItemInfoContainer.appendChild(shopPageLink);
                            shopItemInfoContainer.appendChild(shopFollowed);
                            shopItemContainer.appendChild(shopImgContainer);
                            shopItemContainer.appendChild(shopItemInfoContainer);
                            shopContainer.appendChild(shopName);
                            shopContainer.appendChild(shopItemContainer);
                            contentsContainer.appendChild(shopContainer);
                        });
                    }
                })
                .catch(err => {

                });
        } else {
            console.log('ログアウトしています。');
            window.alert('このページは会員専用ページです。\nトップページに移動します。');
            window.location.href = '/';
        }
        const loading = document.getElementById('loading');
        loading.style.opacity = 0;
        setTimeout(() => {
            loading.style.display = 'none';
        }, 500)
    })
}
