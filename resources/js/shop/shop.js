import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import { Tabs } from "flowbite";

const auth = getAuth();

window.addEventListener('load', init);

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
        } else {
            console.log('ログアウトしています。');
        }
    })
}

const tabElements = [
    {
        id: 'pr',
        triggerEl: document.getElementById('pr-tab'),
        targetEl: document.getElementById('pr')
    },
    {
        id: 'schedule',
        triggerEl: document.getElementById('schedule-tab'),
        targetEl: document.getElementById('schedule')
    },
    {
        id: 'profile',
        triggerEl: document.getElementById('profile-tab'),
        targetEl: document.getElementById('profile')
    },
    {
        id: 'menu',
        triggerEl: document.getElementById('menu-tab'),
        targetEl: document.getElementById('menu')
    }
];

const options = {
    defaultTabId: 'pr',
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
