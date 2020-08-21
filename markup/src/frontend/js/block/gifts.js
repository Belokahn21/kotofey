var oneHeight = 80, // размер одного элемента
	numImage = 10, // количество элементов
	speedStep = 0.2; // скорость изменения скорости
function LetsGo() {
	clearInterval(LetsGo.interval);
	var x = [];
	var num = 0;
	var o = null;
	for (var i in {xxx1: 1}) {
		var ob = 5 + Math.floor(Math.random() * 6), // количество оборотов 5 минимум, 10 - максимум
			nn = Math.random() * numImage;
		num = Math.floor(nn), // выигравший нумер
			o = {
				ob: ob, num: num,
				a: document.getElementById(i), // это наш контрол с классом XXX
				// время=(speedStart)/speedStep
				// расстояние=(speedStart/2)*время -арифм прогр
				// расстояние=speedStart^2/(2*speedStep)
				// speedStart=sqrt(расстояние*2*speedStep)
				speed: Math.sqrt(((ob * numImage + num) * oneHeight) * speedStep * 2), // скорость
				scr: -26 // магия, блин
			}; // выигравший номер
		x.push(o);
	}
	LetsGo.interval = setInterval(
		function () {
			var i = x.length, complete = true;
			while (i--) {
				var a = x[i];
				a.scr += a.speed;
				if (a.speed > 2 * speedStep) {
					a.speed -= speedStep;
					complete = false;
				} else if (a.speed > 0) {
					var t = Math.round(a.scr / oneHeight);
					if (t >= numImage) t = 0;
					console.log(i, t, a.scr - oneHeight * t, a.ob, a.num);
					a.scr = oneHeight * t;
					a.speed = 0;
					complete = false;
				}
				if (a.scr > (oneHeight * numImage))
					a.scr -= oneHeight * numImage;
				a.a.scrollTop = Math.floor(a.scr);
			}
			if (complete) clearInterval(LetsGo.interval)
		}, 20)
}

document.querySelector('.LetsGoClass').addEventListener('click', () => {
	LetsGo();
});