import $ from 'jquery';
window.$ = window.jQuery = $;
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

import './block/product-calc';

import ProductCalc from './block/ProductCalc';

import './block/gifts';
import './block/mobile-menu';
import './block/basket';
import './block/search';
import './block/menu';
import './block/ui-placeholder';
import './block/other-jquery';
import './block/catalog-filter';
import './block/favorite';
import './block/compare';
import './block/toggleClass';
import './block/promocode';
import './include/init-sliders';
import './include/init-range-sliders';
import './include/init-maskedinput';
import './include/init-datepicker';
import './include/phone-mask';
import Catalog from './block/catalog';
import StickFilter from './block/StickFilter';
import RemoveBasketItem from './block/RemoveBasketItem';
import LiveSearch from './block/LiveSearch';

const catalog = new Catalog();
new StickFilter(catalog);
new RemoveBasketItem();
new ProductCalc();
new LiveSearch('.js-live-search');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})


//react js
import './react/cdek-calculator/CdekCalculator';
import './react/search/Search';

