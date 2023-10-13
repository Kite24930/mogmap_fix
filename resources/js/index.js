import './common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import { Loader } from "@googlemaps/js-api-loader";
import { MarkerClusterer } from "@googlemaps/markerclusterer";
import 'flowbite';

window.addEventListener('load', init);
let map, infoWindow, markerClusterer;
const mapEl = document.getElementById('map');

function init() {
    initMap(Laravel.date);
    const loading = document.getElementById('loading');
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
}

function initMap(date) {
    try {
        const loader = new Loader({
            apiKey: 'AIzaSyBMkY2aB3g-6_xLG-rI5AJRQkjqTg4HMRM',
            version: 'weekly',
            libraries: ['places']
        });
        loader.load().then(() => {
            const mieUniv = new google.maps.LatLng(34.74452133045268, 136.52417046859435);
            map = new google.maps.Map(mapEl, {
                zoom: 11,
                center: mieUniv,
                mapTypeControl: false,
                fullscreenControl: false,
                streetViewControl: false,
                gestureHandling: 'greedy',
            });
        });
    } catch (error) {
        console.log(error);
    }
}
