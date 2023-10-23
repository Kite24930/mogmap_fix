import './common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import { Loader } from "@googlemaps/js-api-loader";
import { MarkerClusterer } from "@googlemaps/markerclusterer";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import SimpleBar from "simplebar";

window.addEventListener('load', init);
let map, infoWindow, markerClusterer;
const mapEl = document.getElementById('map');

function init() {
    initMap(Laravel.date);
    initList(Laravel.date);
    initCalendar();
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
            setMarkers(date)
        });
    } catch (error) {
        console.log(error);
    }
}

function setMarkers(targetDate) {
    const toastEl = document.getElementById('toast');
    if (toastEl) toastEl.remove();
    let latList = [];
    let lngList = [];
    let markers = [];
    let eventNum = [];
    Laravel.events.filter((event) => {
        return event.event_date === targetDate;
    }).forEach((event) => {
        let latLng = new google.maps.LatLng(event.event_lat, event.event_lng);
        let icon = 'storage/data/event_pin.png';
        let content = document.createElement('div');
        content.classList.add('map-info-window', 'pb-3', 'pr-3', 'md:pb-0', 'md:pr-0');
        let info = document.createElement('div');
        info.classList.add('map-info', 'flex', 'flex-col', 'items-center');
        let name = document.createElement('p');
        name.classList.add('map-info-name', 'text-lg', 'font-bold');
        name.textContent = event.event_name;
        let place = document.createElement('p');
        place.classList.add('map-info-place', 'text-sm');
        place.textContent = event.event_place_name;
        let address = document.createElement('p');
        address.classList.add('map-info-address', 'text-sm');
        address.textContent = event.event_address;
        let mapOpen = document.createElement('a');
        mapOpen.href = 'https://maps.apple.com/?q=' + event.event_lat + ',' + event.event_lng + '&z=16&t=satellite';
        mapOpen.classList.add('map-open', 'text-sm', 'bg-green-100', 'text-green-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-green-400');
        mapOpen.innerHTML = '<i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く';
        let shopdiv = document.createElement('div');
        shopdiv.classList.add('map-info-shop', 'flex', 'flex-col', 'items-center', 'py-2', 'gap-2');
        Laravel.set_ups.filter((set_up) => {
            return (Number(set_up.event_id) === Number(event.event_id) || Number(set_up.place_id === Number(event.event_place_num))) && set_up.date === targetDate;
        }).forEach((set_up) => {
            eventNum.push(Number(set_up.event_place_num));
            let shop = document.createElement('div');
            shop.classList.add('map-info-shop-item', 'flex', 'flex-col', 'items-center', 'border', 'border-gray-300', 'rounded', 'p-2', 'w-full');
            let shopName = document.createElement('p');
            shopName.classList.add('map-info-shop-name', 'text-lg', 'font-bold');
            shopName.textContent = set_up.shop_name;
            let openTime = document.createElement('p');
            openTime.classList.add('map-info-open-time', 'text-sm');
            if (set_up.start_time !== null && set_up.end_time !== null) {
                const open = set_up.start_time.split(':');
                const close = set_up.end_time.split(':');
                openTime.textContent = Number(open[0]) + ':' + open[1] + ' ~ ' + Number(close[0]) + ':' + close[1];
            } else {
                openTime.textContent = '時間未定';
            }
            let comment = document.createElement('p');
            comment.classList.add('map-info-comment', 'text-xs', 'border', 'border-cyan-400', 'px-1', 'rounded');
            comment.textContent = set_up.comment;
            let link = document.createElement('a');
            link.href = 'shop/' + set_up.shop_id;
            link.classList.add('map-info-link', 'text-sm', 'bg-yellow-100', 'text-yellow-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-yellow-300', 'my-2');
            link.innerHTML = '<i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ';
            let instagram = document.createElement('a');
            instagram.href = 'https://www.instagram.com/' + set_up.instagram + '/';
            instagram.classList.add('map-info-instagram', 'text-sm', 'bg-pink-100', 'text-pink-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-pink-400', 'mb-2');
            instagram.innerHTML = '<i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram';
            shop.appendChild(shopName);
            shop.appendChild(openTime);
            if (set_up.comment !== null && set_up.comment !== '') shop.appendChild(comment);
            shop.appendChild(link);
            shop.appendChild(instagram);
            shopdiv.appendChild(shop);
            if (set_up.status === 0) {
                icon = 'storage/data/event_stop_exist_pin.png';
            }
        });
        info.appendChild(name);
        info.appendChild(place);
        info.appendChild(address);
        info.appendChild(mapOpen);
        info.appendChild(shopdiv);
        content.appendChild(info);
        let marker = new google.maps.Marker({
            position: latLng,
            title: event.event_name,
            icon: {
                url: icon,
                scaledSize: new google.maps.Size(50, 50),
            },
            animation: google.maps.Animation.DROP,
        });
        marker.addListener('click', () => {
            if (infoWindow) infoWindow.close();
            infoWindow = new google.maps.InfoWindow({
                content: content,
                disableAutoPan: false,
            });
            infoWindow.open(map, marker);
        });
        markers.push(marker);
        latList.push(event.event_lat);
        lngList.push(event.event_lng);
    });
    let sameNum = [];
    Laravel.same_lists.filter((same_list) => {
        return same_list.date === targetDate && eventNum.includes(Number(same_list.place_id)) === false;
    }).forEach((same_list) => {
        sameNum.push(Number(same_list.place_id));
        let latLng = new google.maps.LatLng(same_list.lat, same_list.lng);
        let icon = 'storage/data/standard_pin.png';
        let content = document.createElement('div');
        content.classList.add('map-info-window', 'pb-3', 'pr-3', 'md:pb-0', 'md:pr-0');
        let info = document.createElement('div');
        info.classList.add('map-info', 'flex', 'flex-col', 'items-center');
        let place = document.createElement('p');
        place.classList.add('map-info-place', 'text-sm');
        place.textContent = same_list.place_name;
        let address = document.createElement('p');
        address.classList.add('map-info-address', 'text-sm');
        address.textContent = same_list.address;
        let mapOpen = document.createElement('a');
        mapOpen.href = 'https://maps.apple.com/?q=' + same_list.lat + ',' + same_list.lng + '&z=16&t=satellite';
        mapOpen.classList.add('map-open', 'text-sm', 'bg-green-100', 'text-green-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-green-400');
        mapOpen.innerHTML = '<i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く';
        let shopdiv = document.createElement('div');
        shopdiv.classList.add('map-info-shop', 'flex', 'flex-col', 'items-center', 'py-2', 'gap-2');
        Laravel.set_ups.filter((set_up) => {
            return Number(set_up.place_id) === Number(same_list.place_id) && set_up.date === targetDate;
        }).forEach((set_up) => {
            let shop = document.createElement('div');
            shop.classList.add('map-info-shop-item', 'flex', 'flex-col', 'items-center', 'border', 'border-gray-300', 'rounded', 'p-2', 'w-full');
            let name = document.createElement('p');
            name.classList.add('map-info-name', 'text-lg', 'font-bold');
            name.textContent = set_up.shop_name;
            let openTime = document.createElement('p');
            openTime.classList.add('map-info-open-time', 'text-sm');
            if (set_up.start_time !== null && set_up.end_time !== null) {
                const open = set_up.start_time.split(':');
                const close = set_up.end_time.split(':');
                openTime.textContent = Number(open[0]) + ':' + open[1] + ' ~ ' + Number(close[0]) + ':' + close[1];
            } else {
                openTime.textContent = '時間未定';
            }
            let comment = document.createElement('p');
            comment.classList.add('map-info-comment', 'text-xs', 'border', 'border-cyan-400', 'px-1', 'rounded');
            comment.textContent = set_up.comment;
            let link = document.createElement('a');
            link.href = 'shop/' + set_up.shop_id;
            link.classList.add('map-info-link', 'text-sm', 'bg-yellow-100', 'text-yellow-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-yellow-300', 'my-2');
            link.innerHTML = '<i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ';
            let instagram = document.createElement('a');
            instagram.href = 'https://www.instagram.com/' + set_up.instagram + '/';
            instagram.classList.add('map-info-instagram', 'text-sm', 'bg-pink-100', 'text-pink-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-pink-400', 'mb-2');
            instagram.innerHTML = '<i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram';
            shop.appendChild(name);
            shop.appendChild(openTime);
            if (set_up.comment !== null && set_up.comment !== '') shop.appendChild(comment);
            shop.appendChild(link);
            shop.appendChild(instagram);
            shopdiv.appendChild(shop);
            if (set_up.status === 0) {
                icon = 'storage/data/standard_stop_exist_pin.png';
            }
        });
        info.appendChild(place);
        info.appendChild(address);
        info.appendChild(mapOpen);
        info.appendChild(shopdiv);
        content.appendChild(info);
        let marker = new google.maps.Marker({
            position: latLng,
            title: same_list.place_name,
            icon: {
                url: icon,
                scaledSize: new google.maps.Size(50, 50),
            },
            animation: google.maps.Animation.DROP,
        });
        marker.addListener('click', () => {
            if (infoWindow) infoWindow.close();
            infoWindow = new google.maps.InfoWindow({
                content: content,
                disableAutoPan: false,
            });
            infoWindow.open(map, marker);
        });
        markers.push(marker);
        latList.push(same_list.lat);
        lngList.push(same_list.lng);
    })
    Laravel.set_ups.filter((set_up) => {
        return set_up.date === targetDate && set_up.event_id === null && sameNum.includes(Number(set_up.place_id)) === false && eventNum.includes(Number(set_up.place_id)) === false;
    }).forEach((set_up) => {
        let latLng = new google.maps.LatLng(set_up.lat, set_up.lng);
        let icon = 'storage/shop/' + set_up.shop_img;
        if (set_up.status === 0) {
            icon = 'storage/data/stop_pin.png';
        }
        let marker = new google.maps.Marker({
            position: latLng,
            title: set_up.name,
            icon: {
                url: icon,
                scaledSize: new google.maps.Size(50, 50),
            },
            animation: google.maps.Animation.DROP,
        });
        let content = document.createElement('div');
        content.classList.add('map-info-window', 'pb-3', 'pr-3', 'md:pb-0', 'md:pr-0');
        let info = document.createElement('div');
        info.classList.add('map-info', 'flex', 'flex-col', 'items-center');
        let name = document.createElement('p');
        name.classList.add('map-info-name', 'text-lg', 'font-bold');
        name.textContent = set_up.shop_name;
        let place = document.createElement('p');
        place.classList.add('map-info-place', 'text-sm');
        place.textContent = set_up.place_name;
        let address = document.createElement('p');
        address.classList.add('map-info-address', 'text-sm');
        address.textContent = set_up.address;
        let openTime = document.createElement('p');
        openTime.classList.add('map-info-open-time', 'text-sm');
        if (set_up.start_time !== null && set_up.end_time !== null) {
            const open = set_up.start_time.split(':');
            const close = set_up.end_time.split(':');
            openTime.textContent = Number(open[0]) + ':' + open[1] + ' ~ ' + Number(close[0]) + ':' + close[1];
        } else {
            openTime.textContent = '時間未定';
        }
        let comment = document.createElement('p');
        comment.classList.add('map-info-comment', 'text-xs', 'border', 'border-cyan-400', 'px-1', 'rounded');
        comment.textContent = set_up.comment;
        let link = document.createElement('a');
        link.href = 'shop/' + set_up.shop_id;
        link.classList.add('map-info-link', 'text-sm', 'bg-yellow-100', 'text-yellow-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-yellow-300', 'my-2');
        link.innerHTML = '<i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ';
        let instagram = document.createElement('a');
        instagram.href = 'https://www.instagram.com/' + set_up.instagram + '/';
        instagram.classList.add('map-info-instagram', 'text-sm', 'bg-pink-100', 'text-pink-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-pink-400', 'mb-2');
        instagram.innerHTML = '<i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram';
        let mapOpen = document.createElement('a');
        mapOpen.href = 'https://maps.apple.com/?q=' + set_up.lat + ',' + set_up.lng + '&z=16&t=satellite';
        mapOpen.classList.add('map-open', 'text-sm', 'bg-green-100', 'text-green-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-green-400');
        mapOpen.innerHTML = '<i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く';
        // info.appendChild(img);
        info.appendChild(name);
        info.appendChild(place);
        info.appendChild(address);
        info.appendChild(openTime);
        if (set_up.comment !== null && set_up.comment !== '') info.appendChild(comment);
        info.appendChild(link);
        info.appendChild(instagram);
        info.appendChild(mapOpen);
        content.appendChild(info);
        marker.addListener('click', () => {
            if (infoWindow) infoWindow.close();
            infoWindow = new google.maps.InfoWindow({
                content: content,
                disableAutoPan: false,
            });
            infoWindow.open(map, marker);
        });
        markers.push(marker);
        latList.push(set_up.lat);
        lngList.push(set_up.lng);
    });
    if (markers.length !== 0) {
        markerClusterer = new MarkerClusterer({
            map: map,
            markers: markers,
            gridSize: 50,
            minimumClusterSize: 2,
            averageCenter: true,
            styles: [
                {
                    url: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png',
                    height: 50,
                    width: 50,
                    textColor: '#ffffff',
                    textSize: 12,
                },
            ],
        });
        if (latList.length === 1 && lngList.length === 1) {
            map.setCenter(new google.maps.LatLng(latList[0], lngList[0]));
            map.setZoom(16);
        } else {
            let bounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(Math.min.apply(null, latList), Math.min.apply(null, lngList)),
                new google.maps.LatLng(Math.max.apply(null, latList), Math.max.apply(null, lngList))
            );
            map.fitBounds(bounds);
            if (map.getZoom() > 16) map.setZoom(16);
        }
    } else {
        const tabContents = document.getElementById('tabContents');
        map.setCenter(new google.maps.LatLng(34.74452133045268, 136.52417046859435));
        map.setZoom(11);
        let toast = document.createElement('div');
        toast.id = 'toast';
        toast.classList.add('flex', 'items-center', 'p-4', 'text-gray-500', 'bg-white', 'rounded-lg', 'shadow', 'absolute', 'top-16', 'left-1/4', '-translate-x-1/2', 'z-50');
        toast.setAttribute('role', 'alert');
        let container = document.createElement('div');
        container.classList.add('flex', 'items-center', 'justify-between', 'gap-4');
        let text = document.createElement('div');
        text.classList.add('flex', 'items-center', 'justify-start', 'gap-2');
        let icon = document.createElement('i');
        icon.classList.add('bi', 'bi-info-square-fill', 'text-2xl', 'text-yellow-300');
        let message = document.createElement('p');
        message.classList.add('text-sm');
        if (new Date(targetDate) < new Date()) {
            message.textContent = '過去の日付は表示できません';
        } else {
            message.textContent = 'この日には出店がありません';
        }
        text.appendChild(icon);
        text.appendChild(message);
        let close = document.createElement('button');
        close.classList.add('ml-auto', '-mx-1.5', '-my-1.5', 'bg-white', 'text-gray-400', 'hover:text-gray-900', 'rounded-lg', 'focus:ring-2', 'focus:ring-gray-300', 'p-1.5', 'hover:bg-gray-100', 'inline-flex', 'items-center', 'justify-center', 'h-8', 'w-8');
        close.setAttribute('type', 'button');
        close.setAttribute('aria-label', 'Close');
        close.setAttribute('data-dismiss-target', '#toast');
        close.addEventListener('click', () => {
            toast.remove();
        });
        let closeIcon = document.createElement('i');
        closeIcon.classList.add('bi', 'bi-x', 'text-lg');
        close.appendChild(closeIcon);
        container.appendChild(text);
        container.appendChild(close);
        toast.appendChild(container);
        tabContents.appendChild(toast);
    }
}

function initList(targetDate) {
    const list = document.getElementById('list');
    list.innerHTML = '';
    let eventNum = [];
    Laravel.events.filter((event) => {
        return event.event_date === targetDate;
    }).forEach((event) => {
        let eventContainer = document.createElement('div');
        eventContainer.classList.add('event-container', 'flex', 'flex-col', 'items-center', 'border', 'border-gray-300', 'rounded', 'p-2', 'w-full', 'bg-pink-100', 'mb-2');
        let eventInfo = document.createElement('div');
        eventInfo.classList.add('event-info', 'flex', 'flex-col', 'items-center', 'w-full');
        let eventName = document.createElement('p');
        eventName.classList.add('event-name', 'text-lg', 'font-bold');
        eventName.textContent = event.event_name;
        let eventPlace = document.createElement('p');
        eventPlace.classList.add('event-place', 'text-sm');
        eventPlace.textContent = event.event_place_name;
        let eventAddress = document.createElement('p');
        eventAddress.classList.add('event-address', 'text-sm');
        eventAddress.textContent = event.event_address;
        let eventMapOpen = document.createElement('a');
        eventMapOpen.href = 'https://maps.apple.com/?q=' + event.event_lat + ',' + event.event_lng + '&z=16&t=satellite';
        eventMapOpen.classList.add('event-map-open', 'text-sm', 'bg-green-100', 'text-green-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-green-400');
        eventMapOpen.innerHTML = '<i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く';
        let eventShopdiv = document.createElement('div');
        eventShopdiv.classList.add('event-shop', 'flex', 'flex-col', 'items-center', 'py-2', 'gap-2', 'w-full');
        Laravel.set_ups.filter((set_up) => {
            return (Number(set_up.place_id) === Number(event.event_place_num) || Number(set_up.event_id) === Number(event.event_id)) && set_up.date === targetDate;
        }).forEach((set_up) => {
            eventNum.push(Number(set_up.event_place_num));
            let eventShop = document.createElement('div');
            eventShop.classList.add('event-shop-item', 'flex', 'flex-col', 'md:flex-row', 'items-center', 'border', 'border-gray-300', 'rounded', 'p-2', 'w-full', 'bg-white');
            let eventShopDetail = document.createElement('div');
            eventShopDetail.classList.add('event-shop-detail', 'flex', 'flex-col', 'items-center', 'w-full');
            let eventShopName = document.createElement('p');
            eventShopName.classList.add('event-shop-name', 'text-lg', 'font-bold');
            eventShopName.textContent = set_up.shop_name;
            let eventOpenTime = document.createElement('p');
            eventOpenTime.classList.add('event-open-time', 'text-sm');
            if (set_up.start_time !== null && set_up.end_time !== null) {
                const open = set_up.start_time.split(':');
                const close = set_up.end_time.split(':');
                eventOpenTime.textContent = Number(open[0]) + ':' + open[1] + ' ~ ' + Number(close[0]) + ':' + close[1];
            } else {
                eventOpenTime.textContent = '時間未定';
            }
            let comment = document.createElement('p');
            comment.classList.add('event-comment', 'text-xs', 'border', 'border-cyan-400', 'px-1', 'rounded');
            comment.textContent = set_up.comment;
            let eventLinkContainer = document.createElement('div');
            eventLinkContainer.classList.add('event-link-container', 'flex', 'flex-col', 'items-center', 'w-full');
            let eventLink = document.createElement('a');
            eventLink.href = 'shop/' + set_up.shop_id;
            eventLink.classList.add('event-link', 'text-sm', 'bg-yellow-100', 'text-yellow-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-yellow-300', 'my-2');
            eventLink.innerHTML = '<i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ';
            let eventInstagram = document.createElement('a');
            eventInstagram.href = 'https://www.instagram.com/' + set_up.instagram + '/';
            eventInstagram.classList.add('event-instagram', 'text-sm', 'bg-pink-100', 'text-pink-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-pink-400', 'mb-2');
            eventInstagram.innerHTML = '<i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram';
            eventShopDetail.appendChild(eventShopName);
            eventShopDetail.appendChild(eventOpenTime);
            if (set_up.comment !== null && set_up.comment !== '') eventShopDetail.appendChild(comment);
            eventLinkContainer.appendChild(eventLink);
            eventLinkContainer.appendChild(eventInstagram);
            eventShop.appendChild(eventShopDetail);
            eventShop.appendChild(eventLinkContainer);
            eventShopdiv.appendChild(eventShop);
        });
        eventInfo.appendChild(eventName);
        eventInfo.appendChild(eventPlace);
        eventInfo.appendChild(eventAddress);
        eventInfo.appendChild(eventMapOpen);
        eventInfo.appendChild(eventShopdiv);
        eventContainer.appendChild(eventInfo);
        list.appendChild(eventContainer);
    });
    Laravel.set_ups.filter((set_up) => {
        return set_up.date === targetDate && set_up.event_id === null && eventNum.includes(Number(set_up.place_id)) === false;
    }).forEach((set_up) => {
        let container = document.createElement('div');
        container.classList.add('shop-container', 'flex', 'flex-col', 'items-center', 'border', 'border-gray-300', 'rounded', 'p-2', 'w-full', 'mb-2');
        let info = document.createElement('div');
        info.classList.add('shop-info', 'flex', 'flex-col', 'md:flex-row', 'items-center', 'w-full');
        let shopDetail = document.createElement('div');
        shopDetail.classList.add('shop-detail', 'flex', 'flex-col', 'items-center', 'w-full');
        let name = document.createElement('p');
        name.classList.add('shop-name', 'text-lg', 'font-bold');
        name.textContent = set_up.shop_name;
        let place = document.createElement('p');
        place.classList.add('shop-place', 'text-sm');
        place.textContent = set_up.place_name;
        let address = document.createElement('p');
        address.classList.add('shop-address', 'text-sm');
        address.textContent = set_up.address;
        let openTime = document.createElement('p');
        openTime.classList.add('shop-open-time', 'text-sm');
        if (set_up.start_time !== null && set_up.end_time !== null) {
            const open = set_up.start_time.split(':');
            const close = set_up.end_time.split(':');
            openTime.textContent = Number(open[0]) + ':' + open[1] + ' ~ ' + Number(close[0]) + ':' + close[1];
        } else {
            openTime.textContent = '時間未定';
        }
        let comment = document.createElement('p');
        comment.classList.add('shop-comment', 'text-xs', 'border', 'border-cyan-400', 'px-1', 'rounded');
        comment.textContent = set_up.comment;
        let linkContainer = document.createElement('div');
        linkContainer.classList.add('shop-link-container', 'flex', 'flex-col', 'items-center', 'w-full');
        let link = document.createElement('a');
        link.href = 'shop/' + set_up.shop_id;
        link.classList.add('shop-link', 'text-sm', 'bg-yellow-100', 'text-yellow-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-yellow-300', 'my-2');
        link.innerHTML = '<i class="bi bi-shop mr-1 text-yellow-800"></i>ショップページ';
        let instagram = document.createElement('a');
        instagram.href = 'https://www.instagram.com/' + set_up.instagram + '/';
        instagram.classList.add('shop-instagram', 'text-sm', 'bg-pink-100', 'text-pink-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-pink-400', 'mb-2');
        instagram.innerHTML = '<i class="bi bi-instagram mr-1 text-pink-800"></i>Instagram';
        let mapOpen = document.createElement('a');
        mapOpen.href = 'https://maps.apple.com/?q=' + set_up.lat + ',' + set_up.lng + '&z=16&t=satellite';
        mapOpen.classList.add('map-open', 'text-sm', 'bg-green-100', 'text-green-800', 'font-medium', 'px-2.5', 'py-0.5', 'rounded', 'border', 'border-green-400', 'md-2');
        mapOpen.innerHTML = '<i class="bi bi-pin-map mr-1 text-green-800"></i>マップアプリで開く';
        shopDetail.appendChild(name);
        shopDetail.appendChild(place);
        shopDetail.appendChild(address);
        shopDetail.appendChild(openTime);
        if (set_up.comment !== null && set_up.comment !== '') shopDetail.appendChild(comment);
        linkContainer.appendChild(link);
        linkContainer.appendChild(instagram);
        linkContainer.appendChild(mapOpen);
        info.appendChild(shopDetail);
        info.appendChild(linkContainer);
        container.appendChild(info);
        list.appendChild(container);
    });
    const listBar = new SimpleBar(document.getElementById('list'), { autoHide: false });
    listBar.recalculate();
}

function initCalendar() {
    let events = [];
    let duplication = [];
    Laravel.events.forEach((event) => {
        const eventData = {
            id: 'event-' + event.event_id,
            calendarId: 'cal1',
            title: event.event_name,
            start: event.event_date,
            end: event.event_date,
            isAllday: true,
            color: '#F8717188',
        }
        events.push(eventData);
        Laravel.set_ups.filter((set_up) => {
            return set_up.place_id === event.event_place_num && set_up.date === event.event_date;
        }).forEach((set_up) => {
            duplication.push(set_up.id);
        });
    });
    Laravel.set_ups.forEach((set_up) => {
        if (duplication.includes(set_up.id) === false) {
            const eventData = {
                title: set_up.shop_name,
                start: set_up.date,
                end: set_up.date,
                color: '#FBBF2488',
            }
            events.push(eventData);
        }
    });
    function dayClickEventSet() {
        document.querySelectorAll('.fc-day').forEach((day) => {
            day.addEventListener('click', (e) => {
                let target = e.target;
                while (target.classList.contains('fc-day') === false) {
                    target = target.parentNode;
                }
                const targetDate = target.getAttribute('data-date');
                const selected = document.querySelector('.fc-day.selected');
                if (selected) selected.classList.remove('selected');
                target.classList.add('selected');
                document.querySelector('.fc-toolbar-date').textContent = '-' + new Date(targetDate).getDate().toString();
                if (MarkerClusterer) markerClusterer.clearMarkers();
                setMarkers(targetDate);
                initList(targetDate);
            })
        });
    }
    const calendarEl = document.getElementById('calendar');
    const calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        customButtons: {
            customPrev: {
                text: '<',
                click: () => {
                    calendar.prev();
                    dayClickEventSet();
                }
            },
            customNext: {
                text: '>',
                click: () => {
                    calendar.next();
                    dayClickEventSet();
                }
            }
        },
        headerToolbar: {
            left: 'customPrev',
            center: 'title',
            right: 'customNext',
        },
        titleFormat: { month: 'long' },
        initialDate: new Date(),
        events: events,
        timeZone: 'Asia/Tokyo',
    })
    calendar.render();
    document.querySelector('.fc-day[data-date="' + new Date().toISOString().slice(0, 10) + '"]').classList.add('selected');
    const toolbarDate = document.createElement('span');
    toolbarDate.classList.add('fc-toolbar-date');
    document.querySelector('.fc-toolbar-title').appendChild(toolbarDate);
    dayClickEventSet();
}

document.querySelectorAll('.tab-btn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
        document.querySelectorAll('.tab-btn').forEach((btn) => {
            btn.classList.remove('active');
        });
        e.target.classList.add('active');
    });
});
