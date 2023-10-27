import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        https: true,
    },
    build: {
        manifest: true,
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                appCss: 'resources/css/app.css',
                common: 'resources/js/common.js',
                commonCss: 'resources/css/common.css',
                welcome: 'resources/js/welcome.js',
                welcomeCss: 'resources/css/welcome.css',
                index: 'resources/js/index.js',
                indexCss: 'resources/css/index.css',
                shopList: 'resources/js/shop/shop-list.js',
                shopListCss: 'resources/css/shop/shop-list.css',
                shop: 'resources/js/shop/shop.js',
                shopCss: 'resources/css/shop/shop.css',
                accountCss: 'resources/css/account.css',
                mypage: 'resources/js/account/mypage.js',
                followed: 'resources/js/account/followed.js',
                accountEdit: 'resources/js/account/account-edit.js',
                shopEdit: 'resources/js/shop/shop-edit.js',
                foodsBond: 'resources/js/foods_bond.js',
                foodsBondCss: 'resources/css/foods_bond.css',
                footer: 'resources/js/footer.js',
                footerCss: 'resources/css/footer.css',
            }
        }
    }
});
