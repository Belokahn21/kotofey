import React from 'react';

class Menu extends React.Component {
	render() {
		return (
			<ul className="menu">
				<li className="menu__item"><a className="menu__link" href="/"><span>Сайт</span><span className="menu__icon"><i className="fas fa-globe-americas"></i></span></a></li>
				<li className="menu__item"><a className="menu__link" href="/"><span>Рабочий стол</span><span className="menu__icon"><i className="fas fas fa-tachometer-alt"></i></span></a></li>
				<li className="menu__item"><a className="menu__link" href="/"><span>Магазин</span><span className="menu__icon"><i className="fas fa-store"></i></span></a></li>
			</ul>
		)
	}
}

module.exports = Menu;