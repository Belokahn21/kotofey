import datepicker from 'air-datepicker';
import Inputmask from "maskedinput";
import lightbox from "lightbox2";
import Swiper from 'swiper';
import uiplaceholder from './block/ui-placeholder';

var counter = 0;
var mask = new Inputmask('+7 (999) 999 99-99');
if (document.querySelector('.maskedinput-js')) {
	mask.mask(document.querySelector('.maskedinput-js'));
}

var swiper = new Swiper('.swiper-container', {
    slidesPerView: 4,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,

    },
    breakpoints: {
        0: {
            slidesPerView: 1,
            spaceBetween: 0,
        },
        1390: {
            slidesPerView: 4,
            spaceBetween: 30
        }
    }
});