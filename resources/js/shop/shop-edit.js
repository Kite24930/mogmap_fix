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
                    if (res.data.status === 'ok' && res.data.shop_id.includes(Number(document.getElementById('shop_id').value))) {
                        console.log('このページは閲覧できます。');
                    } else {
                        console.log('このページは閲覧できません。');
                        window.alert('このページは閲覧できません。\nマイページに移動します。');
                        window.location.href = '/mypage';
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

const shopName = document.getElementById('shop_name');
const genreId = document.getElementById('genre_id');
const newGenre = document.getElementById('new_genre');
const reserve = document.getElementById('reserve');
const prefectures = document.querySelectorAll('.prefecture');
const area = document.getElementById('area');
const instagram = document.getElementById('instagram');
const twitter = document.getElementById('twitter');
const facebook = document.getElementById('facebook');
const shopImg = document.getElementById('shop_img');
const shopImgPreview = document.getElementById('shop_img_preview');
const prImg1 = document.getElementById('pr_img_1');
const prImg1Preview = document.getElementById('pr_img_1_preview');
const prTxt1 = document.getElementById('pr_txt_1');
const prImg2 = document.getElementById('pr_img_2');
const prImg2Preview = document.getElementById('pr_img_2_preview');
const prTxt2 = document.getElementById('pr_txt_2');
const prImg3 = document.getElementById('pr_img_3');
const prImg3Preview = document.getElementById('pr_img_3_preview');
const prTxt3 = document.getElementById('pr_txt_3');

genreId.addEventListener('change', (e) => {
    if (e.target.value === '0') {
        newGenre.classList.remove('hidden');
    } else {
        newGenre.classList.add('hidden');
    }
})

function areaSet() {
    let areaList = [];
    prefectures.forEach(prefecture => {
        if (prefecture.checked) {
            areaList.push(prefecture.value);
        }
    })
    area.value = areaList.join(',');
}

prefectures.forEach(prefecture => {
    prefecture.addEventListener('change', areaSet);
})

shopImg.addEventListener('change', (e) => {
    const file = e.target.files[0];
    shopImgPreview.src = file ? URL.createObjectURL(file) : '';
})

prImg1.addEventListener('change', (e) => {
    const file = e.target.files[0];
    prImg1Preview.src = file ? URL.createObjectURL(file) : '';
})

prImg2.addEventListener('change', (e) => {
    const file = e.target.files[0];
    prImg2Preview.src = file ? URL.createObjectURL(file) : '';
})

prImg3.addEventListener('change', (e) => {
    const file = e.target.files[0];
    prImg3Preview.src = file ? URL.createObjectURL(file) : '';
})
