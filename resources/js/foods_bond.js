import './common.js';
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

window.addEventListener('load', init);
function init() {
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
}

document.querySelectorAll('.flipSwiper').forEach(el => {
    let swiper = new Swiper(el, {
        effect: "flip",
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
});

