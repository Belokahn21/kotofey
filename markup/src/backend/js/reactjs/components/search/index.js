import React from 'react';
import ReactDom from 'react-dom';

import Result from '../search_result/index';

class Search extends React.Component {

    constructor() {
        super();
        this.timerId = null;
        this.state = {
            result: []
        };

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(e) {
        let elements = [];
        let value = e.target.value;
        let timerTime = 3000;
        const url = "http://local.kotofey.store/rest/product/get/?text=" + value;

        if (this.timerId) {
            clearTimeout(this.timerId);
        }

        this.timerId = setTimeout(() => {
            fetch(url)
                .then(response => response.json())
                .then(commits => this.renderResult(JSON.parse(commits)));
        }, timerTime);
    }

    renderResult(elements) {
        this.setState({
            result: elements
        });
    }

    render() {
        return (
            <form className="search-form">
                <input className="search-form__input" name="search" placeholder="Поиск по сайту..." onChange={this.handleClick}/>
                <div className="search-result-wrap">Результаты:
                    <ul className="search-result">
                        {this.state.result.map((product, index) => {
                            return <li className="search-result__item" key={index}><a href="" className="search-result__link">{product.name}</a></li>
                        })}
                    </ul>
                </div>
            </form>
        )
    }
}

ReactDom.render(<Search/>, document.querySelector('.search-admin'));