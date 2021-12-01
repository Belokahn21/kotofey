import $ from 'jquery';
import * as Cookies from "es-cookie";
import ReactDom from "react-dom";
import React from "react";

window.$ = window.jQuery = $;
window.Cookies = Cookies;
import 'lightbox2';
import 'popper.js';
import 'bootstrap';

// class block
import ProductCalc from './block/PoductCalc/ProductCalc';
import Menu from './block/Menu';
import Favorite from './block/favorite';
import Compare from './block/Compare';
import Catalog from './block/Catalog';
import StickFilter from './block/StickFilter';
import RemoveBasketItem from './block/RemoveBasketItem';
import FastCart from './block/FastCart';
import LiveSearch from "./block/LiveSearch";
import HelpDashboard from "./classes/HelpDashboard/HelpDashboard";
import SiteMessage from "./classes/SiteMessage";
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
new SiteMessage();


document.addEventListener('DOMContentLoaded', () => {
    new ProductCalc(new FastCart());
});

//react js
import './react/Search/Search';
import './react/Checkout/Checkout';
import './react/Page/Page';
import './react/ProductAdmission/ProductAdmission';
import './react/Compare/CompareButton';
import './react/Compare/CompareList';
import './react/EatCalculator/EatCalculator';
import './react/RepeatOrder/RepeatOrder';
import './react/OzonApi/Ozon';


import SetWeight from "./react/SetWeight/SetWeight";

const set_weight_elements = document.querySelectorAll('.set-weight-react');
if (set_weight_elements) {
    set_weight_elements.forEach(el => {
        ReactDom.render(<SetWeight product_id={el.getAttribute('data-product-id')}/>, el);
    });
}


import BuyOneClick from "./react/BuyOneClick/BuyOneClick";

let buy_one_click_elements = document.querySelectorAll('.buy-one-click-react');
if (buy_one_click_elements) {
    buy_one_click_elements.forEach(el => {
        let product_id = el.getAttribute('data-product-id');
        if (product_id) {
            ReactDom.render(<BuyOneClick product_id={product_id}/>, el);
        } else {
            ReactDom.render(<BuyOneClick/>, el);
        }
    });
}
