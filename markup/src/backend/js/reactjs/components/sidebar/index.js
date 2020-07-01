import React from 'react';
import ReactDom from 'react-dom';
import Search from "../search";

class Sidebar extends React.Component {
	render() {
		return (
			<aside className="left-side">
				<button className="button-toggle-sidebar js-toggle-sidebar" type="button">Меню</button>
				<div className="left-sidebar-container">
					<div className="sidebar-title">Поиск по сайту</div>
					<Search/>
					<div className="sidebar-title">Быстрый доступ</div>
					<ul className="fast-links">
						<li className="fast-links__item">
							<div className="point"></div>
							<a className="fast-links__link" href="/"><i className="fas fa-receipt"></i></a></li>
						<li className="fast-links__item"><a className="fast-links__link" href="/"><i className="fas fa-cubes"></i></a></li>
					</ul>
					<div className="sidebar-title">Меню</div>
					<ul className="menu">
						<li className="menu__item"><a className="menu__link" href="/"><span>Сайт</span><span className="menu__icon"><i className="fas fa-globe-americas"></i></span></a></li>
						<li className="menu__item"><a className="menu__link" href="/"><span>Рабочий стол</span><span className="menu__icon"><i className="fas fas fa-tachometer-alt"></i></span></a></li>
						<li className="menu__item"><a className="menu__link" href="/"><span>Магазин</span><span className="menu__icon"><i className="fas fa-store"></i></span>
							<ul className="menu-sub">
								<li className="menu-sub__item"><a className="menu-sub__link" href="/"><span>Заказы</span><span className="menu__icon"><i className="fas fa-store"></i></span></a></li>
								<li
									className="menu-sub__item"><a className="menu-sub__link" href="/"><span>Товары</span><span className="menu__icon"><i className="fas fa-store"></i></span></a></li>
								<li className="menu-sub__item"><a className="menu-sub__link" href="/"><span>Поставщики</span><span className="menu__icon"><i className="fas fa-store"></i></span></a></li>
							</ul>
						</a>
						</li>
					</ul>
				</div>
			</aside>
		)
	}
}

ReactDom.render(<Sidebar/>, document.querySelector('.left-side-react'));