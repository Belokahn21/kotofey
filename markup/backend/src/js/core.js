import $ from 'jquery';
window.$ = window.jQuery = $;
import 'popper.js';
import 'bootstrap';

import './react/components/sidebar';
import './react/components/statistic';
import './react/components/todo';
import './react/components/FindProduct';
import './react/components/Media/Media';
import './react/components/Cdn/Cdn';
// import './react/components/Promotion/Promotion';


import './block/CheckExistProduct';
import './block/OrderLoadProduct';
import './block/PhoneMask';
import './block/notify';
import CleanOrderPhone from './block/CleanOrderPhone';
import './include/datepicker';
import './include/other-jquery';
import './include/maskedinput';
import ProductVendorFill from './block/ProductVendorFill';
import SetPrice from './block/SetPrice';

new ProductVendorFill();
new SetPrice('.set-price');
new CleanOrderPhone();

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
    buttonToggleSlider.addEventListener('click', (event) => {
        let sideElement = document.querySelector('.left-sidebar-container');

        if (sideElement) {
            sideElement.classList.toggle('is-active');
        }
    });
}