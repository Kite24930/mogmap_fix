import '../common.js';
import { getAuth, onAuthStateChanged } from "firebase/auth";
import { loader } from "../module/firebase.js";
import { MarkerClusterer } from "@googlemaps/markerclusterer";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import axios from "axios";
import geolib from "geolib";

window.addEventListener('load', init);
let map, infoWindow, markerClusterer;
const mapEl = document.getElementById('map');

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
                    if (res.data.status === 'ok' && res.data.shop_id.includes(Number(document.getElementById('shop_id').value))) {
                        console.log('このページは閲覧できます。');
                    } else {
                        console.log('このページは閲覧できません。');
                        window.alert('このページは閲覧できません。\nマイページに移動します。');
                        window.location.href = '/mypage';
                    }
                    initMap();
                    initCalendar();
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

window.Laravel.selectDate = [];
const multipleDate = document.getElementById('multipleDate');
const selectDate = document.getElementById('selectDate');
const startTime = document.getElementById('start_time');
const endTime = document.getElementById('end_time');
const notDecided = document.getElementById('notDecided');
const eventSelect = document.getElementById('eventSelect');
const eventValid = document.getElementById('eventValid');
const event = document.getElementById('event');
const newEvent = document.getElementById('newEvent');
const placeSearch = document.getElementById('placeSearch');
const placeSearchBtn = document.getElementById('placeSearchBtn');
const placeId = document.getElementById('place_id');
const address = document.getElementById('address');
const addressSearchBtn = document.getElementById('addressSearchBtn');
const candidate = document.getElementById('candidate');
const candidateList = document.getElementById('candidateList');
const locationCheck = document.getElementById('locationCheck');
const submitBtn = document.getElementById('submit');
const scheduleEditBtns = document.querySelectorAll('.schedule-edit');
const scheduleDeleteBtns = document.querySelectorAll('.schedule-delete');
const scheduleCanceledBtns = document.querySelectorAll('.schedule-canceled');
const scheduleCancellationBtns = document.querySelectorAll('.schedule-cancellation');

function initMap() {
    try {
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
            markerClusterer = new MarkerClusterer({
                map: map,
            });
        });
    } catch (error) {
        console.log(error);
    }
}

function initCalendar() {
    let setups = [];
    Laravel.setup_lists.forEach(setup => {
        let color = '#FBBF24BB';
        if (setup.event_id !== null) color = '#34D399BB';
        if (setup.status === 0) color = '#5555ff44';
        setups.push({
            title: setup.place_name,
            start: setup.date,
            end: setup.date,
            isAllDay: true,
            color: color,
        });
    });

    function dayClickEventSet() {
        document.querySelectorAll('.fc-day').forEach(day => {
            day.removeEventListener('click', dayClickEvent);
            day.addEventListener('click', dayClickEvent);
        });
    }

    function dayClickEvent(e) {
        let target = e.target;
        while (target.classList.contains('fc-day') === false) {
            target = target.parentNode;
        }
        const targetDate = new Date(target.getAttribute('data-date'));
        const today = new Date().setHours(0, 0, 0, 0);
        if (targetDate < today) return;
        if (multipleDate.checked) {
            if (target.classList.contains('selected')) {
                target.classList.remove('selected');
            } else {
                target.classList.add('selected');
            }
        } else {
            const selected = document.querySelector('.fc-day.selected');
            if (selected) selected.classList.remove('selected');
            target.classList.add('selected');
        }
        Laravel.selectDate = [];
        selectDate.innerHTML = '';
        document.querySelectorAll('.fc-day.selected').forEach(day => {
            Laravel.selectDate.push(day.getAttribute('data-date'));
            const date = document.createElement('li');
            date.textContent = day.getAttribute('data-date');
            selectDate.appendChild(date);
        });
        if (Laravel.selectDate.length !== 0 && Laravel.setup_lists.length !== 0) {
            let duplication = false;
            Laravel.selectDate.forEach(date => {
                if (Laravel.setup_lists.some(setup => setup.date === date)) {
                    duplication = true;
                }
            });
            if (duplication) window.alert('選択した日付には既に登録されている日程があります。\nこの日付に登録する場合は新規登録となります。\nすでに登録されている予定を編集する場合は、登録リストから編集を選択してください。')
        }
    }
    const today = new Date().getFullYear() + '-' + (new Date().getMonth() + 1).toString().padStart(2, '0') + '-' + new Date().getDate().toString().padStart(2, '0')
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
        initialDate: today,
        events: setups,
        timeZone: 'Asia/Tokyo',
    });
    calendar.render();
    const toolbarDate = document.createElement('span');
    toolbarDate.classList.add('fc-toolbar-date');
    document.querySelector('.fc-toolbar-title').appendChild(toolbarDate);
    dayClickEventSet();
}

multipleDate.addEventListener('change', () => {
    document.querySelectorAll('.fc-day.selected').forEach(day => {
        day.classList.remove('selected');
    });
    Laravel.selectDate = [];
    selectDate.innerHTML = '';
    if (multipleDate.checked) {
        eventSelect.classList.add('hidden');
    } else {
        eventSelect.classList.remove('hidden');
    }
});

notDecided.addEventListener('change', () => {
    if (notDecided.checked) {
        startTime.disabled = true;
        endTime.disabled = true;
        startTime.classList.add('bg-gray-100', 'text-gray-700');
        endTime.classList.add('bg-gray-100', 'text-gray-700');
    } else {
        startTime.disabled = false;
        endTime.disabled = false;
        startTime.classList.remove('bg-gray-100', 'text-gray-700');
        endTime.classList.remove('bg-gray-100', 'text-gray-700');
    }
});

eventValid.addEventListener('change', () => {
    if (eventValid.checked) {
        event.classList.remove('hidden');
        newEvent.classList.add('hidden');
    } else {
        event.classList.add('hidden');
        newEvent.classList.add('hidden');
    }
});

event.addEventListener('change', () => {
    if (event.value === '-1') {
        newEvent.classList.remove('hidden');
    } else {
        newEvent.classList.add('hidden');
    }
});

placeSearchBtn.addEventListener('click', () => {
    if (placeSearch.value === '') return;
    loading.style.opacity = 1;
    loading.style.display = 'flex';
    let placeCandidate = [];
    Laravel.places.forEach(place => {
        if (place.place_name.indexOf(placeSearch.value) !== -1) {
            placeCandidate.push(place);
        }
    });
    console.log(placeCandidate);
    if (placeCandidate.length === 0) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: placeSearch.value }, (results, status) => {
            if (status === 'OK') {
                console.log(results);
                const targetPlace = results[0];
                placeId.value = 0;
                const addLength = results[0].address_components.length;
                let geoAddress = '';
                for (let i = addLength - 3; i > -1; i--) {
                    geoAddress += results[0].address_components[i].long_name;
                }
                address.value = geoAddress;
                candidate.classList.add('hidden');
                const location = new google.maps.LatLng(targetPlace.geometry.location.lat(), targetPlace.geometry.location.lng());
                Laravel.location.lat = targetPlace.geometry.location.lat();
                Laravel.location.lng = targetPlace.geometry.location.lng();
                map.setCenter(location);
                map.setZoom(15);
                markerClusterer.clearMarkers();
                let marker = new google.maps.Marker({
                    position: location,
                    title: targetPlace.formatted_address,
                    map: map,
                    icon: {
                        url: '/storage/data/standard_pin.png',
                        scaledSize: new google.maps.Size(50, 58)
                    },
                    animation: google.maps.Animation.DROP,
                    draggable: true,
                });
                marker.addListener('dragend', () => {
                    map.setCenter(marker.getPosition());
                    Laravel.location.lat = marker.getPosition().lat();
                    Laravel.location.lng = marker.getPosition().lng();
                });
                markerClusterer.addMarkers([
                    marker
                ]);
                address.readOnly = true;
                address.classList.add('bg-gray-100', 'text-gray-700');
                const targetLocation = { latitude: targetPlace.geometry.location.lat(), longitude: targetPlace.geometry.location.lng() };
                placeCandidate = [];
                Laravel.places.forEach(place => {
                    const candidateLocation = { latitude: place.lat, longitude: place.lng };
                    const distance = geolib.getDistance(targetLocation, candidateLocation);
                    if (distance < 200) {
                        placeCandidate.push(place);
                    }
                });
                if (placeCandidate.length === 0) {
                    locationCheck.classList.remove('hidden');
                    window.alert('検索が成功しました。\n地図上の場所を確認してください。');
                } else {
                    candidateList.innerHTML = '';
                    placeCandidate.forEach(place => {
                        const candidate = document.createElement('div');
                        candidate.classList.add('candidate', 'px-2.5', 'py-0.5', 'bg-red-100', 'border', 'border-red-500', 'rounded', 'cursor-pointer');
                        candidate.textContent = place.place_name + '(' + place.address + ')';
                        candidate.addEventListener('click', () => {
                            placeSearch.value = place.place_name;
                            placeId.value = place.id;
                            address.value = place.address;
                            candidate.classList.add('hidden');
                            const location = new google.maps.LatLng(place.lat, place.lng);
                            map.setCenter(location);
                            map.setZoom(15);
                            markerClusterer.clearMarkers();
                            let marker = new google.maps.Marker({
                                position: location,
                                title: targetPlace.formatted_address,
                                map: map,
                                icon: {
                                    url: '/storage/data/standard_pin.png',
                                    scaledSize: new google.maps.Size(50, 58)
                                },
                                animation: google.maps.Animation.DROP,
                                draggable: true,
                            });
                            marker.addListener('dragend', () => {
                                map.setCenter(marker.getPosition());
                                Laravel.location.lat = marker.getPosition().lat();
                                Laravel.location.lng = marker.getPosition().lng();
                            });
                            markerClusterer.addMarkers([
                                marker
                            ]);
                            candidateList.innerHTML = '';
                            candidate.classList.add('hidden');
                            window.alert('検索が成功しました。\n地図上の場所を確認してください。');
                        });
                        candidateList.appendChild(candidate);
                    });
                    candidate.classList.remove('hidden');
                    locationCheck.classList.remove('hidden');
                    window.alert('検索でヒットした地点の近くに複数の候補が見つかりました。\n候補リストを確認して該当する場所がある場合は選択してください。');
                }
            } else {
                console.log(status);
                address.readOnly = false;
                address.classList.remove('bg-gray-100', 'text-gray-700');
                addressSearchBtn.classList.remove('hidden');
                window.alert('場所名での住所検索に失敗しました。\n住所欄に住所を入力して、住所の検索を行ってください。')
            }
        });
    } else if (placeCandidate.length === 1) {
        const targetPlace = placeCandidate[0];
        placeId.value = targetPlace.id;
        address.value = targetPlace.address;
        candidate.classList.add('hidden');
        const location = new google.maps.LatLng(targetPlace.lat, targetPlace.lng);
        map.setCenter(location);
        map.setZoom(15);
        markerClusterer.clearMarkers();
        let marker = new google.maps.Marker({
            position: location,
            title: targetPlace.formatted_address,
            map: map,
            icon: {
                url: '/storage/data/standard_pin.png',
                scaledSize: new google.maps.Size(50, 58)
            },
            animation: google.maps.Animation.DROP,
            draggable: true,
        });
        marker.addListener('dragend', () => {
            map.setCenter(marker.getPosition());
            Laravel.location.lat = marker.getPosition().lat();
            Laravel.location.lng = marker.getPosition().lng();
        });
        markerClusterer.addMarkers([
            marker
        ]);
        window.alert('検索が成功しました。\n地図上の場所を確認してください。');
    } else {
        candidateList.innerHTML = '';
        placeCandidate.forEach(place => {
            const candidate = document.createElement('div');
            candidate.classList.add('candidate', 'px-2.5', 'py-0.5', 'bg-red-100', 'border', 'border-red-500', 'rounded', 'cursor-pointer');
            candidate.textContent = place.place_name + '(' + place.address + ')';
            candidate.addEventListener('click', () => {
                placeSearch.value = place.place_name;
                placeId.value = place.id;
                address.value = place.address;
                candidate.classList.add('hidden');
                const location = new google.maps.LatLng(place.lat, place.lng);
                map.setCenter(location);
                map.setZoom(15);
                markerClusterer.clearMarkers();
                let marker = new google.maps.Marker({
                    position: location,
                    title: targetPlace.formatted_address,
                    map: map,
                    icon: {
                        url: '/storage/data/standard_pin.png',
                        scaledSize: new google.maps.Size(50, 58)
                    },
                    animation: google.maps.Animation.DROP,
                    draggable: true,
                });
                marker.addListener('dragend', () => {
                    map.setCenter(marker.getPosition());
                    Laravel.location.lat = marker.getPosition().lat();
                    Laravel.location.lng = marker.getPosition().lng();
                });
                markerClusterer.addMarkers([
                    marker
                ]);
                candidateList.innerHTML = '';
                candidate.classList.add('hidden');
                window.alert('検索が成功しました。\n地図上の場所を確認してください。');
            });
            candidateList.appendChild(candidate);
        });
        candidate.classList.remove('hidden');
        window.alert('複数の候補が見つかりました。\n候補リストの中から選択してください。');
    }
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
});

addressSearchBtn.addEventListener('click', () => {
    if (address.value === '') return;
    loading.style.opacity = 1;
    loading.style.display = 'flex';
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: address.value }, (results, status) => {
        if (status === 'OK') {
            console.log(results);
            const targetPlace = results[0];
            placeId.value = 0;
            candidate.classList.add('hidden');
            const location = new google.maps.LatLng(targetPlace.geometry.location.lat(), targetPlace.geometry.location.lng());
            Laravel.location.lat = targetPlace.geometry.location.lat();
            Laravel.location.lng = targetPlace.geometry.location.lng();
            map.setCenter(location);
            map.setZoom(15);
            markerClusterer.clearMarkers();
            let marker = new google.maps.Marker({
                position: location,
                title: targetPlace.formatted_address,
                map: map,
                icon: {
                    url: '/storage/data/standard_pin.png',
                    scaledSize: new google.maps.Size(50, 58)
                },
                animation: google.maps.Animation.DROP,
                draggable: true,
            });
            marker.addListener('dragend', () => {
                map.setCenter(marker.getPosition());
            });
            markerClusterer.addMarkers([
                marker
            ]);
            const targetLocation = { latitude: targetPlace.geometry.location.lat(), longitude: targetPlace.geometry.location.lng() };
            let placeCandidate = [];
            Laravel.places.forEach(place => {
                const candidateLocation = { latitude: place.lat, longitude: place.lng };
                const distance = geolib.getDistance(targetLocation, candidateLocation);
                if (distance < 200) {
                    placeCandidate.push(place);
                }
            });
            if (placeCandidate.length === 0) {
                locationCheck.classList.remove('hidden');
                window.alert('検索が成功しました。\n地図上の場所を確認してください。');
            } else {
                candidateList.innerHTML = '';
                placeCandidate.forEach(place => {
                    const candidate = document.createElement('div');
                    candidate.classList.add('candidate', 'px-2.5', 'py-0.5', 'bg-red-100', 'border', 'border-red-500', 'rounded', 'cursor-pointer');
                    candidate.textContent = place.place_name + '(' + place.address + ')';
                    candidate.addEventListener('click', () => {
                        placeSearch.value = place.place_name;
                        placeId.value = place.place_id;
                        address.value = place.address;
                        candidate.classList.add('hidden');
                        const location = new google.maps.LatLng(place.lat, place.lng);
                        map.setCenter(location);
                        map.setZoom(15);
                        markerClusterer.clearMarkers();
                        let marker = new google.maps.Marker({
                            position: location,
                            title: targetPlace.formatted_address,
                            map: map,
                            icon: {
                                url: '/storage/data/standard_pin.png',
                                scaledSize: new google.maps.Size(50, 58)
                            },
                            animation: google.maps.Animation.DROP,
                            draggable: true,
                        });
                        marker.addListener('dragend', () => {
                            map.setCenter(marker.getPosition());
                            Laravel.location.lat = marker.getPosition().lat();
                            Laravel.location.lng = marker.getPosition().lng();
                        });
                        markerClusterer.addMarkers([
                            marker
                        ]);
                        candidateList.innerHTML = '';
                        candidate.classList.add('hidden');
                        window.alert('検索が成功しました。\n地図上の場所を確認してください。');
                    });
                    candidateList.appendChild(candidate);
                });
                candidate.classList.remove('hidden');
                locationCheck.classList.remove('hidden');
                window.alert('検索でヒットした地点の近くに複数の候補が見つかりました。\n候補リストを確認して該当する場所がある場合は選択してください。');
            }
        } else {
            console.log(status);
            window.alert('住所検索に失敗しました。\n住所を正しく入力してください。')
        }
    });
    loading.style.opacity = 0;
    setTimeout(() => {
        loading.style.display = 'none';
    }, 500)
});

submitBtn.addEventListener('click', () => {
    let sendData = {};
    sendData.shop_id = Laravel.shop_id;
    if (Laravel.setup_id !== 0) {
        sendData.setup_id = Laravel.setup_id;
    } else {
        sendData.setup_id = null;
    }
    if (Laravel.selectDate.length === 0) {
        window.alert('日程を選択してください。');
        return;
    }
    sendData.date = Laravel.selectDate;
    if (placeId.value === '') {
        window.alert('開催場所を選択してください。');
        return;
    } else if (placeId.value === '0') {
        if (address.value === '') {
            window.alert('開催場所を選択してください。');
            return;
        } else {
            sendData.place_id = 0;
            sendData.place_name = placeSearch.value;
            sendData.address = address.value;
            sendData.lat = Laravel.location.lat;
            sendData.lng = Laravel.location.lng;
        }
    } else {
        sendData.place_id = placeId.value;
    }
    if (notDecided.checked) {
        sendData.start_time = null;
        sendData.end_time = null;
    } else if (startTime.value === '' || endTime.value === '') {
        window.alert('開始時間と終了時間を入力してください。');
        return;
    } else {
        sendData.start_time = startTime.value + ':00';
        sendData.end_time = endTime.value + ':00';
    }
    if (startTime.value > endTime.value) {
        window.alert('開始時間が終了時間より後になっています。');
        return;
    }
    if (eventValid.checked) {
        if (event.value === '-1') {
            if (newEvent.value === '') {
                window.alert('イベント名を入力してください。');
                return;
            } else {
                sendData.event_id = -1;
                sendData.event_name = newEvent.value;
            }
        } else {
            sendData.event_id = event.value;
        }
    } else {
        sendData.event_id = null;
    }
    console.log(sendData);
    axios.post('/api/setup/register', sendData)
        .then(res => {
            console.log(res.data);
            if (res.data.msg === 'ok') {
                window.alert('登録が完了しました。');
                window.location.reload();
            } else {
                window.alert('登録に失敗しました。\n再度登録してください。');
            }
        })
        .catch(err => {
            console.log(err);
            window.alert('登録に失敗しました。\n再度登録してください。');
        });
});

scheduleEditBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const setupID = e.target.getAttribute('data-setup-id');
        const setup = Laravel.setup_lists.find(setup => setup.id === Number(setupID));
        Laravel.setup_id = setup.id;
        Laravel.selectDate = [setup.date];
        multipleDate.checked = false;
        selectDate.innerHTML = '';
        const date = document.createElement('li');
        date.textContent = setup.date;
        selectDate.appendChild(date);
        document.querySelector('.fc-day[data-date="' + setup.date + '"]').classList.add('selected');
        if (setup.event_id === null) {
            eventValid.checked = false;
            event.classList.add('hidden');
            newEvent.classList.add('hidden');
        } else {
            eventValid.checked = true;
            event.classList.remove('hidden');
            newEvent.classList.add('hidden');
            event.value = setup.event_id;
        }
        if (setup.start_time !== null) {
            notDecided.checked = false;
            startTime.disabled = false;
            endTime.disabled = false;
            startTime.classList.remove('bg-gray-100', 'text-gray-700');
            endTime.classList.remove('bg-gray-100', 'text-gray-700');
            startTime.value = setup.start_time.slice(0, -3);
            endTime.value = setup.end_time.slice(0, -3);
        } else {
            notDecided.checked = true;
            startTime.disabled = true;
            endTime.disabled = true;
            startTime.classList.add('bg-gray-100', 'text-gray-700');
            endTime.classList.add('bg-gray-100', 'text-gray-700');
        }
        placeSearch.value = setup.place_name;
        placeId.value = setup.place_id;
        address.value = setup.address;
        candidate.classList.add('hidden');
        const location = new google.maps.LatLng(setup.lat, setup.lng);
        Laravel.location.lat = setup.lat;
        Laravel.location.lng = setup.lng;
        map.setCenter(location);
        map.setZoom(15);
        markerClusterer.clearMarkers();
        let marker = new google.maps.Marker({
            position: location,
            title: setup.place_name,
            map: map,
            icon: {
                url: '/storage/data/standard_pin.png',
                scaledSize: new google.maps.Size(50, 58)
            },
            animation: google.maps.Animation.DROP,
            draggable: true,
        });
        marker.addListener('dragend', () => {
            map.setCenter(marker.getPosition());
            Laravel.location.lat = marker.getPosition().lat();
            Laravel.location.lng = marker.getPosition().lng();
        });
        markerClusterer.addMarkers([
            marker
        ]);
        address.readOnly = true;
        address.classList.add('bg-gray-100', 'text-gray-700');
        locationCheck.classList.add('hidden');
        submitBtn.textContent = '編集';
        window.scrollTo(0, 0);
        window.alert('編集モードに移行しました。\n編集後、編集ボタンを押してください。\n編集をキャンセルする場合は、画面を再読み込みしてください。');
    });
});

scheduleDeleteBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const setupID = e.target.getAttribute('data-setup-id');
        axios.post('/api/setup/delete', { setup_id: setupID })
            .then(res => {
                if (res.data.msg === 'ok') {
                    window.alert('削除が完了しました。');
                    window.location.reload();
                } else {
                    window.alert('削除に失敗しました。\n再度削除してください。');
                }
            })
            .catch(err => {
                console.log(err);
                window.alert('削除に失敗しました。\n再度削除してください。');
            });
    });
});

scheduleCanceledBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const setupID = e.target.getAttribute('data-setup-id');
        axios.post('/api/setup/canceled', { setup_id: setupID })
            .then(res => {
                if (res.data.msg === 'ok') {
                    window.alert('出店キャンセルが完了しました。');
                    window.location.reload();
                } else {
                    window.alert('出店キャンセルに失敗しました。\n再度キャンセルしてください。');
                }
            })
            .catch(err => {
                console.log(err);
                window.alert('出店キャンセルに失敗しました。\n再度キャンセルしてください。');
            });
    });
});

scheduleCancellationBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        const setupID = e.target.getAttribute('data-setup-id');
        axios.post('/api/setup/cancellation', { setup_id: setupID })
            .then(res => {
                if (res.data.msg === 'ok') {
                    window.alert('出店キャンセルを取り消しました。');
                    window.location.reload();
                } else {
                    window.alert('出店キャンセルの取り消しに失敗しました。\n再度取り消ししてください。');
                }
            })
            .catch(err => {
                console.log(err);
                window.alert('出店キャンセルの取り消しに失敗しました。\n再度取り消ししてください。');
            });
    });
});
