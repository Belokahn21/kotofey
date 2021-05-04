import React from 'react';
import ReactDom from 'react-dom';

class Page extends React.Component {
    constructor(props) {
        super(props);

        this.title = document.title ? document.title : {};
        this.keywords = document.querySelector('meta[name="keywords"]') ? document.querySelector('meta[name="keywords"]').getAttribute('content') : {};
    }

    render() {
        return <div className="page-info">
            <ul className="page-info-list">
                <li className="page-info-list__item">
                    <div className="page-info-list__key">Длина заголовка:</div>
                    <div className="page-info-list__value">{this.title.length}</div>
                </li>
                <li className="page-info-list__item">
                    <div className="page-info-list__key">Ключи:</div>
                    <div className="page-info-list__value">{this.keywords.length}</div>
                </li>
            </ul>
        </div>
    }
}

let element = document.querySelector('.page-react');
if (element) ReactDom.render(<Page/>, element);