window.onresize = function (e) {
	if (document.querySelector('#width-info')) {
		document.querySelector('#width-info').remove();
	}
	let panel = document.createElement('div');
	panel.setAttribute('id', 'width-info');
	panel.setAttribute('style', 'width:200px;height:40px;position:fixed;top:0;right:0;');
	panel.textContent = window.outerWidth;
	document.querySelector('body').append(panel);
}