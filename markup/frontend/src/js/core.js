import $ from 'jquery';

window.$ = window.jQuery = $;
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

// class block
import ProductCalc from './block/PoductCalc/ProductCalc';
import Menu from './block/Menu';
import Favorite from './block/favorite';
import Compare from './block/compare';
import Catalog from './block/Catalog';
import StickFilter from './block/StickFilter';
import RemoveBasketItem from './block/RemoveBasketItem';
import FastCart from './block/FastCart';
import LiveSearch from "./block/LiveSearch";
import HelpDashboard from "./classes/HelpDashboard/HelpDashboard";
// import SmoothChangeNumber from "./classes/SmoothChangeNumber";

// no class block
import './block/gifts';
import './block/mobile-menu';
import './block/basket';
import './block/search';
import './block/ui-placeholder';
import './block/other-jquery';
import './block/catalog-filter';
import './block/toggleClass';
import './block/promocode';

// init
import './include/init-sliders';
import './include/init-range-sliders';
import './include/init-maskedinput';
import './include/init-datepicker';
import './include/phone-mask';

new StickFilter(new Catalog());
new RemoveBasketItem();
new Compare();
new Favorite();
new Menu();
new LiveSearch('.js-live-search');
// new SmoothChangeNumber('[data-smooth-change]');
new HelpDashboard();


document.addEventListener('DOMContentLoaded', () => {
    new ProductCalc(new FastCart());
});

//react js
// import './react/cdek-calculator/CdekCalculator';
import './react/search/Search';
import './react/checkout/Checkout';
import './react/BuyOneClick/BuyOneClick';
import './react/Page/Page';