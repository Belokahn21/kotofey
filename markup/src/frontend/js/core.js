import $ from 'jquery';
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

import './block/product-calc';

import ProductCalc from './block/ProductCalc';

import './block/mobile-menu';
import './block/basket';
import './block/search';
import './block/menu';
import './block/ui-placeholder';
import './block/other-jquery';
import './block/catalog-filter';
import  './block/favorite';
import './block/compare';
import './block/toggleClass';
import './block/promocode';
import './include/init-sliders';
import './include/init-range-sliders';
import './include/init-maskedinput';
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
    $("[rel='tooltip']").tooltip();
});