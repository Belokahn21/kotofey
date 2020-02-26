$(document).ready(function () {
	$('.mobile-menu__item.hamb').click(function () {
		var $this = $(this);
		toggleIcon($this);

		if (menuIsVisible()) {
			hideMenu();
		} else {
			showMenu();
		}
	});

	function menuIsVisible() {
		return $('.mobile-menu-full-wrap').css('display') !== 'none';
	}

	function hideMenu() {
		$('.mobile-menu-full-wrap').css('display', 'none').removeClass('run-animate');
	}

	function showMenu() {
		$('.mobile-menu-full-wrap').css('display', 'flex').addClass('run-animate');
	}

	function toggleIcon($item) {
		if ($item.find('i').length === 0) {
			return false;
		}
		var $targetIcon = $item.find('i');
		$targetIcon.toggleClass('fa-times fa-bars');
		$targetIcon.toggleClass('run-animate');
	}
});