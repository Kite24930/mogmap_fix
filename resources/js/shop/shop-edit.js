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
const menuContainer = document.getElementById('menuContainer');
const menuCount = document.getElementById('menu_count');
const menus = document.querySelectorAll('.menu');
const prices = document.querySelectorAll('.price');
const menuDeleteBtns = document.querySelectorAll('.menu-delete');
const categoryCheckbox = document.querySelectorAll('.category-checkbox');
const menuContainerAdd = document.getElementById('menuContainerAdd');

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

categoryCheckbox.forEach(category => {
    category.addEventListener('change', (e) => {
        categoryApplicable(e);
    })
})

function categoryApplicable(e) {
    const target = e.target.getAttribute('data-toggle-target');
    const targetEl = document.getElementById(target);
    if (e.target.checked) {
        targetEl.classList.add('hidden');
        targetEl.value = 0;
    } else {
        targetEl.classList.remove('hidden');
        targetEl.value = '';
    }
}

menuDeleteBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
        menuDelete(e);
    })
})

function menuDelete(e) {
    const targetNum = Number(e.target.getAttribute('data-target-num'));
    const latestNum = Number(menuCount.value);
    for (let i = targetNum; i < latestNum; i++) {
        const pasteNum = i;
        const copyNum = i + 1;
        const pasteMenu = document.getElementById('menu_' + pasteNum);
        const copyMenu = document.getElementById('menu_' + copyNum);
        const pastePrice = document.getElementById('price_' + pasteNum);
        const copyPrice = document.getElementById('price_' + copyNum);
        const pasteCategory = document.getElementById('category_' + pasteNum);
        const copyCategory = document.getElementById('category_' + copyNum);
        pasteMenu.value = copyMenu.value;
        pastePrice.value = copyPrice.value;
        pasteCategory.checked = copyCategory.checked;
        if (pasteCategory.checked) {
            pastePrice.classList.add('hidden');
        } else {
            pastePrice.classList.remove('hidden');
        }
    }
    document.getElementById('menuWrapper_' + latestNum).remove();
    menuCount.value = latestNum - 1;
}

menuContainerAdd.addEventListener('click', () => {
    if (document.getElementById('menu_' + menuCount.value).value !== '' && document.getElementById('price_' + menuCount.value).value !== '') {
        const count = Number(menuCount.value) + 1;
        const addContainer = document.createElement('div');
        addContainer.classList.add('flex', 'flex-col', 'gap-4', 'items-start', 'md:items-center', 'p-4', 'rounded-lg', 'border', 'w-full');
        const labelContainer = document.createElement('div');
        labelContainer.classList.add('flex', 'gap-4', 'items-center', 'w-full');
        const label = document.createElement('label');
        label.classList.add('block', 'font-medium', 'text-sm', 'text-gray-700');
        label.textContent = 'メニュー' + count;
        const categoryContainer = document.createElement('label');
        const category = document.createElement('input');
        category.classList.add('border-gray-300', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'rounded-md', 'shadow-sm', 'category-checkbox');
        category.setAttribute('type', 'checkbox');
        category.setAttribute('data-toggle-target', 'price_' + count);
        category.id = 'category_' + count;
        category.name = 'category_' + count;
        category.textContent = ' カテゴリ名';
        categoryContainer.appendChild(category);
        categoryContainer.innerHTML += 'カテゴリ名';
        labelContainer.appendChild(label);
        labelContainer.appendChild(categoryContainer);
        addContainer.appendChild(labelContainer);
        const menuWrapper = document.createElement('div');
        menuWrapper.classList.add('flex', 'flex-col', 'md:flex-row', 'gap-4', 'items-start', 'md:items-center', 'w-full');
        const menu = document.createElement('input');
        menu.classList.add('border-gray-300', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'rounded-md', 'shadow-sm', 'w-full', 'max-w-md');
        menu.setAttribute('type', 'text');
        menu.id = 'menu_' + count;
        menu.name = 'menu_' + count;
        menu.placeholder = 'メニュー名';
        const price = document.createElement('input');
        price.classList.add('border-gray-300', 'focus:border-indigo-500', 'focus:ring-indigo-500', 'rounded-md', 'shadow-sm', 'w-full', 'max-w-md');
        price.setAttribute('type', 'number');
        price.id = 'price_' + count;
        price.name = 'price_' + count;
        price.placeholder = '価格';
        const deleteBtn = document.createElement('button');
        deleteBtn.classList.add('inline-flex', 'items-center', 'px-4', 'py-2', 'bg-gray-800', 'border', 'border-transparent', 'rounded-md', 'font-semibold', 'text-xs', 'text-white', 'uppercase', 'tracking-widest', 'hover:bg-gray-700', 'focus:bg-gray-700', 'active:bg-gray-900', 'focus:outline-none', 'focus:ring-2', 'focus:ring-indigo-500', 'focus:ring-offset-2', 'transition', 'ease-in-out', 'duration-150', 'menu-delete');
        deleteBtn.setAttribute('type', 'button');
        deleteBtn.setAttribute('data-target-num', count);
        deleteBtn.textContent = '削除';
        deleteBtn.addEventListener('click', (e) => {
            menuDelete(e);
        })
        menuWrapper.appendChild(menu);
        menuWrapper.appendChild(price);
        menuWrapper.appendChild(deleteBtn);
        addContainer.appendChild(menuWrapper);
        menuContainer.appendChild(addContainer);
        document.getElementById('category_' + count).addEventListener('change', (e) => {
            categoryApplicable(e);
        });
        menuCount.value = count;
    } else {
        window.alert('一番下の欄にメニュー名と価格を入力してください。');
    }
})
