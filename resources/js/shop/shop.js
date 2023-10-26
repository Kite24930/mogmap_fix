import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import { Tabs } from "flowbite";
import followingShop from "../module/following.js";
import axios from "axios";

const auth = getAuth();

window.addEventListener('load', init);

const followBtn = document.getElementById('followBtn');
const loginAlert = () => {
    window.alert('ログインしてください。');
}

function init() {
    initSchedule();
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
    onAuthStateChanged(getAuth(), user => {
        if (user) {
            console.log('ログインしています。');
            const shopId = followBtn.getAttribute('data-shop-id');
            axios.post('/api/shop/follow/check', {
                user_id: user.uid,
                shop_id: shopId,
            })
                .then(res => {
                    const followMethod = () => {
                        const type = followBtn.getAttribute('data-type');
                        const status = followingShop(shopId, user.uid, type);
                        if (status !== 'error') {
                            switch (type) {
                                case 'following':
                                    followBtn.classList.add('bg-pink-500');
                                    followBtn.innerHTML = '<i class="bi bi-arrow-through-heart text-2xl text-pink-100 group-hover:text-pink-500"></i>';
                                    followBtn.setAttribute('data-type', 'unfollowing');
                                    window.alert('フォローしました。');
                                    break;
                                case 'unfollowing':
                                    followBtn.classList.remove('bg-pink-500');
                                    followBtn.innerHTML = '<i class="bi bi-heart-arrow mr-1 text-pink-500 group-hover:text-pink-100"></i><i class="bi bi-heart text-pink-500 group-hover:text-pink-100"></i>';
                                    followBtn.setAttribute('data-type', 'following');
                                    window.alert('フォローを解除しました。');
                                    break;
                            }
                        } else {
                            window.alert('エラーが発生しました。');
                        }
                    }
                    followBtn.removeEventListener('click', loginAlert);
                    switch (res.data.status) {
                        case 'following':
                            followBtn.classList.remove('bg-pink-100', 'hover:bg-pink-500');
                            followBtn.classList.add('bg-pink-500', 'hover:bg-pink-100');
                            followBtn.innerHTML = '<i class="bi bi-arrow-through-heart text-2xl text-pink-100 group-hover:text-pink-500"></i>';
                            followBtn.setAttribute('data-type', 'unfollowing');
                            break;
                        case 'unfollowing':
                            followBtn.classList.remove('bg-pink-500', 'hover:bg-pink-100');
                            followBtn.classList.add('bg-pink-100', 'hover:bg-pink-500');
                            followBtn.innerHTML = '<i class="bi bi-heart-arrow mr-1 text-pink-500 group-hover:text-pink-100"></i><i class="bi bi-heart text-pink-500 group-hover:text-pink-100"></i>';
                            followBtn.setAttribute('data-type', 'following');
                            break;
                    }
                    followBtn.addEventListener('click', followMethod);
                })
                .catch(err => {
                    console.log(err);
                });
        } else {
            followBtn.removeEventListener('click', followMethod);
            console.log('ログアウトしています。');
            followBtn.innerHTML = 'i class="bi bi-heart-arrow mr-1 text-pink-500"></i><i class="bi bi-heart text-pink-500"></i>';
            followBtn.addEventListener('click', loginAlert);
        }
    })
}

const tabElements = [];
if (document.getElementById('pr')) {
    tabElements.push({
        id: 'pr',
        triggerEl: document.getElementById('pr-tab'),
        targetEl: document.getElementById('pr')
    });
}
tabElements.push(
    {
        id: 'schedule',
        triggerEl: document.getElementById('schedule-tab'),
        targetEl: document.getElementById('schedule')
    },
    {
        id: 'profile',
        triggerEl: document.getElementById('profile-tab'),
        targetEl: document.getElementById('profile')
    }
);
if (document.getElementById('menu')) {
    tabElements.push({
        id: 'menu',
        triggerEl: document.getElementById('menu-tab'),
        targetEl: document.getElementById('menu')
    });
}

const options = {
    activeClasses: 'bg-green-500',
    inactiveClasses: 'bg-green-100',
}

const tabs = new Tabs(tabElements, options);

const cardSwiper = new Swiper('.cardSwiper', {
    effect: 'cards',
    grabCursor: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

function initSchedule() {

}
