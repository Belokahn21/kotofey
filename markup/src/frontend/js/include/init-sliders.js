import Swiper from "swiper";


var swiper = new Swiper('.slider-container', {
	slidesPerView: 1,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	pagination: {
		el: '.slider-pagination',
		dynamicBullets: true,
		clickable: true,
	},
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev',
	}
});
var swiperCategory = new Swiper('.category-slider-container', {
	slidesPerView: 1,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	pagination: {
		el: '.swiper-pagination',
		type: 'progressbar',
	},
	breakpoints: {
		480: { // when window width is >= 480px
			slidesPerView: 3,
			spaceBetween: 28,
		}
	},
	navigation: {
		nextEl: '.slider-swiper-button-next',
		prevEl: '.slider-swiper-button-prev',
	}
});
var swiperChoose = new Swiper('.vitrine-container', {
	slidesPerView: 1,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	breakpoints: {
		480: { // when window width is >= 480px
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
var swiperBrands = new Swiper('.brand-slider-container', {
	slidesPerView: 2,
	slidesPerColumn: 2,
	spaceBetween: 30,
	pagination: {
		el: '.swiper-pagination',
		clickable: true,
	},
	navigation: {
		nextEl: '.brand-slider-button-next',
		prevEl: '.brand-slider-button-prev',
	},
	breakpoints: {
		480: { // when window width is >= 480px
			slidesPerView: 6,
			slidesPerColumn: 2,
			spaceBetween: 30,
		}
	},
});
var swiperAbout = new Swiper('.about-slider-container', {
	slidesPerView: 1,
	loop: true,
	autoplay: {
		delay: 5000,
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
var swiperSertificate = new Swiper('.sertificate-container', {
	slidesPerView: 1,
	loop: true,
	spaceBetween: 30,
	autoplay: {
		delay: 5000,
	},
	breakpoints: {
		480: { // when window width is >= 480px
			slidesPerView: 4,
			spaceBetween: 30,
		}
	},
	// pagination: {
	// 	el: '.about-slider-pagination',
	// 	dynamicBullets: true,
	// 	clickable: true,
	// },
	navigation: {
		nextEl: '.sertificate-button-next',
		prevEl: '.sertificate-button-prev',
	},
});

let swiperInstagramContainer = new Swiper('.instagram-container', {
	slidesPerView: 1,
	spaceBetween: 25,
	loop: true,
	autoplay: {
		delay: 5000,
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