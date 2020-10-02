import $ from 'jquery';
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

import './block/product-calc';
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

const catalog = new Catalog();
new StickFilter(catalog);
new RemoveBasketItem();

$(function () {
    $("[rel='tooltip']").tooltip();
});