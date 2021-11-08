import $ from 'jquery';
import 'lightbox2';


window.$ = window.jQuery = $;
import 'popper.js';
import 'bootstrap';

import './react/components/sidebar';
import './react/components/statistic';
import './react/components/todo/Todo';
import './react/components/FindProduct';
import './react/components/Media/Media';
import './react/components/Cdn/Cdn';
import './react/components/RepeatOrder/RepeatOrder';
// import './react/components/Promotion/Promotion';
import './react/components/MediaBrowser/MediaBrowser';
import './react/components/FindCustomer/FindCustomer';
import './react/components/OperatorCalculator/OperatorCalculator';


import CopyFormElement from "./block/CopyFormElement";
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
import LoadBreedSizes from './block/LoadBreedSizes';

new ProductVendorFill();
new SetPrice('.set-price');
new CleanOrderPhone();
new CopyFormElement();
new LoadBreedSizes();

let buttonToggleSlider = document.querySelector('.js-toggle-sidebar');
if (buttonToggleSlider) {
    buttonToggleSlider.addEventListener('click', (event) => {
        let sideElement = document.querySelector('.left-sidebar-container');

        if (sideElement) {
            sideElement.classList.toggle('is-active');
        }
    });
}
$(document).ready(function () {
    $("[rel='tooltip']").tooltip();
});
