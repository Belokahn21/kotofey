import React from 'react';
import ReactDom from 'react-dom';
import Search from "../search";
import Menu from "../menu";
import MenuFast from "../menu_fast";

class Sidebar extends React.Component {
    render() {
        return (
            <aside className="left-side">
                <button className="button-toggle-sidebar js-toggle-sidebar" type="button">Показать меню</button>
                <div className="left-sidebar-container">
                    <div className="sidebar-title">Поиск по сайту</div>
                    <Search/>
                    <div className="sidebar-title">Быстрый доступ</div>
                    <MenuFast/>
                    <div className="sidebar-title">Меню</div>
                    <Menu/>

                    <div className="bottom-menu">
                        <a className="bottom-menu__item" href="/logout/"><i className="fas fa-sign-out-alt"></i></a>
                        <a className="bottom-menu__item" href="/cache/"><i className="fas fa-sync-alt"></i></a>
                        <a className="bottom-menu__item" href="/profile/"><i className="fas fa-user-cog"></i></a>
                    </div>
                </div>
            </aside>
        )
    }
}

const sidebar = document.querySelector('.left-sidebar-react');
if (sidebar) {
    ReactDom.render(<Sidebar/>, sidebar);
}
