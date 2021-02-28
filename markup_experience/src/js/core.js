import $ from 'jquery';

window.$ = window.jQuery = $;
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

console.log("asdasd");

import * as ProductCalc from './block/PoductCalc/ProductCalc';
import './block/gifts';
import './block/mobile-menu';
import './block/basket';
import './block/search';
import * as Menu from './block/Menu';
import './block/ui-placeholder';
import './block/other-jquery';
import './block/catalog-filter';
import * as Favorite from './block/favorite';
import * as Compare from './block/compare';
import './block/toggleClass';
import './block/promocode';
import './include/init-sliders';
import './include/init-range-sliders';
import './include/init-maskedinput';
import './include/init-datepicker';
import './include/phone-mask';
import * as Catalog from './block/catalog';
import * as StickFilter from './block/StickFilter';
import * as RemoveBasketItemfrom from './block/RemoveBasketItem';
import * as MiniCart from './block/FastCart';

new StickFilter(new Catalog());
new RemoveBasketItem();
new Compare();
new Favorite();
new Menu();


document.addEventListener('DOMContentLoaded', () => {
    new ProductCalc(new MiniCart());
});

//react js
import './react/cdek-calculator/CdekCalculator';
import './react/search/Search';

