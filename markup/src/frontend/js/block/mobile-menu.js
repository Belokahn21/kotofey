document.querySelectorAll('.header-mobile__hamburger, .header-mobile-full__switch').forEach((element) => {
	element.addEventListener('click', function (event) {
		let fullMenu = document.querySelector('.header-mobile-full');

		if (!fullMenu) {
			return false;
		}

		fullMenu.classList.toggle('active');
	});
});
