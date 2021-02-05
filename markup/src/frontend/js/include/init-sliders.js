import Swiper from "swiper";

let swiper = new Swiper('.slider-container', {
    slidesPerView: 1,
    loop: true,
    effect: 'fade',
    autoplay: {
        delay: 5000,
    },
    pagination: {
        el: '.slider-pagination',
        dynamicBullets: true,
        clickable: true,
    },
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    }
});
let swiperCategory = new Swiper('.category-slider-container', {
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 5000,
    },

    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'progressbar',
    },
    breakpoints: {
        550: { // when window width is >= 480px
            slidesPerView: 3,
            spaceBetween: 28,
        }
    },
    navigation: {
        nextEl: '.slider-swiper-button-next',
        prevEl: '.slider-swiper-button-prev',
    }
});
let swiperChoose = new Swiper('.vitrine-container', {
    slidesPerView: 1,
    loop: true,
    lazy: true,
    // preloadImages: true,
    preloadImages: false,
    autoplay: {
        delay: 5000,
    },
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    breakpoints: {
        550: { // when window width is >= 480px
            slidesPerView: 4,
            spaceBetween: 25,
        }
    },
    pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
        clickable: true,
    },
});
let swiperBrands = new Swiper('.brand-slider-container', {
    slidesPerView: 2,
    slidesPerColumn: 2,
    spaceBetween: 30,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    navigation: {
        nextEl: '.brand-slider-button-next',
        prevEl: '.brand-slider-button-prev',
    },
    breakpoints: {
        550: { // when window width is >= 480px
            slidesPerView: 6,
            slidesPerColumn: 2,
            spaceBetween: 30,
        }
    },
});
let swiperAbout = new Swiper('.about-slider-container', {
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 5000,
    },
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    pagination: {
        el: '.about-slider-pagination',
        dynamicBullets: true,
        clickable: true,
    },
    navigation: {
        nextEl: '.about-slider-button-next',
        prevEl: '.about-slider-button-prev',
    },
});
let swiperInstagramContainer = new Swiper('.instagram-container', {
    slidesPerView: 1,
    spaceBetween: 25,
    lazy: true,
    loop: true,
    autoplay: {
        delay: 5000,
    },
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    pagination: {
        el: '.instagram-pagination',
        dynamicBullets: true,
        clickable: true,
    },
    navigation: {
        nextEl: '.instagram-button-next',
        prevEl: '.instagram-button-prev',
    },

    breakpoints: {
        480: { // when window width is >= 480px
            slidesPerView: 5,
            spaceBetween: 25,
        }
    },
});
let swiperMiniSliderContainer = new Swiper('.mini-slider-container', {
    slidesPerView: 1,
    spaceBetween: 0,
    lazy: true,
    loop: true,
    on: {
        init() {
            this.el.addEventListener('mouseenter', () => {
                this.autoplay.stop();
            });

            this.el.addEventListener('mouseleave', () => {
                this.autoplay.start();
            });
        }
    },
    autoplay: {
        delay: 5000,
    },
});


let aboutSliderContainer = new Swiper('.about-swiper-container', {
    pagination: {
        el: '.about-swiper-pagination',
        dynamicBullets: true,
    },
});