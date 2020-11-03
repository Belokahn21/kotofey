import $ from 'jquery';
import 'popper.js';
import 'bootstrap';
window.$ = window.jQuery = $;

import '../reactjs/components/sidebar';
import '../reactjs/components/statistic';
import '../reactjs/components/todo';


import './block/CheckExistProduct';
import './block/OrderLoadProduct';
import './block/PhoneMask';
import './block/notify';
import './include/datepicker';
import './include/other-jquery';
import './include/maskedinput';
import ProductVendorFill from './block/ProductVendorFill';
import SetPrice from './block/SetPrice';

new ProductVendorFill();
new SetPrice('.set-price');

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
    buttonToggleSlider.addEventListener('click', (event) => {
        let sideElement = document.querySelector('.left-sidebar-container');

        if (sideElement) {
            sideElement.classList.toggle('is-active');
        }
    });
}