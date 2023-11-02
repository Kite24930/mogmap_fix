import '../common.js';
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import axios from "axios";
import { getAuth, onAuthStateChanged } from "firebase/auth";
import followingShop from "../module/following.js";

window.addEventListener('load', init);
let map, infoWindow, markerClusterer, calendar, followMethod;

function init() {
    initList();
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500);
    initFollow();
}

function initList() {
    document.querySelectorAll('.shopSwiper').forEach(el => {
        let swiper = new Swiper(el, {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            mousewheel: true,
        });
    });
}

function initFollow() {
    const auth = getAuth();
    const arrow = document.createElement('i');
    arrow.classList.add('bi', 'bi-heart-arrow', 'text-pink-500', 'mr-1');
    const heart = document.createElement('i');
    heart.classList.add('bi', 'bi-heart-fill', 'text-pink-500', 'mr-1');
    const arrowHeart = document.createElement('i');
    arrowHeart.classList.add('bi', 'bi-arrow-through-heart-fill', 'text-pink-500', 'mr-1');
    onAuthStateChanged(auth, (user) => {
        if (user) {
            axios.post('/api/followedGet', {
                uid: user.uid
            })
                .then(res => {
                    console.log(res.data);
                    followMethod = (e) => {
                        const type = e.target.getAttribute('data-type');
                        const shopId = e.target.getAttribute('data-shop-id');
                        const status = followingShop(shopId, user.uid, type);
                        if (status !== 'error') {
                            switch (type) {
                                case 'following':
                                    e.target.classList.remove('bg-pink-100', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100');
                                    e.target.classList.add('bg-pink-500', 'text-pink-100', 'hover:bg-pink-100', 'hover:text-pink-500');
                                    e.target.innerHTML = '<i class="bi bi-arrow-through-heart text-pink-100 group-hover:text-pink-500"></i>フォロー中';
                                    e.target.setAttribute('data-type', 'unfollowing');
                                    window.alert('フォローしました。');
                                    break;
                                case 'unfollowing':
                                    e.target.classList.remove('bg-pink-500', 'text-pink-100', 'hover:bg-pink-100', 'hover:text-pink-500');
                                    e.target.classList.add('bg-pink-100', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100');
                                    e.target.innerHTML = '<i class="bi bi-heart-arrow mr-1 text-pink-500 group-hover:text-pink-100"></i><i class="bi bi-heart text-pink-500 group-hover:text-pink-100"></i>フォローする';
                                    e.target.setAttribute('data-type', 'following');
                                    window.alert('フォローを解除しました。');
                                    break;
                            }
                        } else {
                            window.alert('エラーが発生しました。');
                        }
                    }
                    document.querySelectorAll('.spin-load-wrapper').forEach(el => {
                        el.remove();
                    });
                    document.querySelectorAll('.follow').forEach(el => {
                        el.removeEventListener('click', followAlert);
                        el.addEventListener('click', followMethod);
                        if (res.data.follow_shop_id.includes(Number(el.getAttribute('data-shop-id')))) {
                            el.classList.remove('bg-pink-100', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100');
                            el.classList.add('bg-pink-500', 'text-pink-100', 'hover:bg-pink-100', 'hover:text-pink-500');
                            el.innerHTML = '<i class="bi bi-arrow-through-heart text-pink-100 group-hover:text-pink-500"></i>フォロー中';
                            el.setAttribute('data-type', 'unfollowing');
                        } else {
                            el.classList.remove('bg-pink-500', 'text-pink-100', 'hover:bg-pink-100', 'hover:text-pink-500');
                            el.classList.add('bg-pink-100', 'text-pink-500', 'hover:bg-pink-500', 'hover:text-pink-100');
                            el.innerHTML = '<i class="bi bi-heart-arrow mr-1 text-pink-500 group-hover:text-pink-100"></i><i class="bi bi-heart text-pink-500 group-hover:text-pink-100"></i>フォローする';
                            el.setAttribute('data-type', 'following');
                        }
                    });
                }).catch(err => {
                    console.log(err);
                });
        } else {
            document.querySelectorAll('.spin-load-wrapper').forEach(el => {
                el.remove();
            });
            document.querySelectorAll('.follow').forEach(el => {
                el.removeEventListener('click', followMethod);
                el.appendChild(arrow.cloneNode(true));
                el.appendChild(heart.cloneNode(true));
                el.innerHTML += 'フォローする';
                el.addEventListener('click', followAlert);
            });
        }
    });
}

function followAlert() {
    alert('フォローするにはログインしてください。');
}
