import datepicker from 'air-datepicker';
import Inputmask from "maskedinput";
import lightbox from "lightbox2";
import Swiper from 'swiper';

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