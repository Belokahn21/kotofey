import $ from 'jquery';

window.$ = window.jQuery = $;
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

console.log("asdasd");

import ProductCalc from './block/PoductCalc/ProductCalc';
import './block/gifts';
import './block/mobile-menu';
import './block/basket';
import './block/search';
import Menu from './block/Menu';
import './block/ui-placeholder';
import './block/other-jquery';
import './block/catalog-filter';
import Favorite from './block/favorite';
import Compare from './block/compare';
import './block/toggleClass';
import './block/promocode';
import './include/init-sliders';
import './include/init-range-sliders';
import './include/init-maskedinput';
import './include/init-datepicker';
import './include/phone-mask';
import Catalog from './block/Catalog';
import StickFilter from './block/StickFilter';
import RemoveBasketItem from './block/RemoveBasketItem';
import FastCart from './block/FastCart';

new StickFilter(new Catalog());
new RemoveBasketItem();
new Compare();
new Favorite();
new Menu();


document.addEventListener('DOMContentLoaded', () => {
    new ProductCalc(new FastCart());
});

//react js
// import './react/cdek-calculator/CdekCalculator';
// import './react/search/Search';
import './react/checkout/Checkout';