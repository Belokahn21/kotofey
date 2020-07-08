import React from 'react';
import ReactDom from 'react-dom';
import Search from "../search";
import Menu from "../menu";
import MenuFast from "../menu_fast";

class Sidebar extends React.Component {
	render() {
		return (
			<aside className="left-side">
				<button className="button-toggle-sidebar js-toggle-sidebar" type="button">Меню</button>
				<div className="left-sidebar-container">
					<div className="sidebar-title">Поиск по сайту</div>
					<Search/>
					<div className="sidebar-title">Быстрый доступ</div>
					<MenuFast/>
					<div className="sidebar-title">Меню</div>
					<Menu/>
				</div>
			</aside>
		)
	}
}

if(document.querySelector('.left-side-react')){
	ReactDom.render(<Sidebar/>, document.querySelector('.left-side-react'));
}
