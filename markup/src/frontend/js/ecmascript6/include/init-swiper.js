import Swiper from "swiper";

var swiper = new Swiper('.mini-catalog-container', {
	slidesPerView: 4,
	spaceBetween: 30,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	pagination: {
		el: '.mini-catalog-pagination',
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
var companies = new Swiper('.companies-container', {
	slidesPerView: 5,
	spaceBetween: 5,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	pagination: {
		el: '.companies-swiper-pagination',
		clickable: true,

	},
	breakpoints: {
		0: {
			slidesPerView: 1,
			spaceBetween: 0,
		},
		1390: {
			slidesPerView: 5,
			spaceBetween: 5
		}
	}
});
var instagramm = new Swiper('.swiper-instagram-container', {
	slidesPerView: 4,
	spaceBetween: 30,
	loop: true,
	autoplay: {
		delay: 5000,
	},
	pagination: {
		el: '.swiper-instagram-pagination',
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