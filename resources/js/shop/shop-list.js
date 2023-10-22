import '../common.js';
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import axios from "axios";
import { getAuth, onAuthStateChanged } from "firebase/auth";

window.addEventListener('load', init);
let map, infoWindow, markerClusterer, calendar;

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
            axios.get('/api/followed/' + user.uid)
                .then(res => {

                }).catch(err => {
                    console.log(err);
                });
        } else {
            document.querySelectorAll('.spin-load-wrapper').forEach(el => {
                el.remove();
            });
            document.querySelectorAll('.follow').forEach(el => {
                el.appendChild(arrow.cloneNode(true));
                el.appendChild(heart.cloneNode(true));
                el.innerHTML += 'フォローする';
                el.addEventListener('click', () => {
                    alert('フォローするにはログインしてください。');
                });
            });
        }
    });
}
