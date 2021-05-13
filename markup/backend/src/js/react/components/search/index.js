import React from 'react';
import Result from './result';
import config from '../../config';

class Search extends React.Component {
    constructor() {
        super();
        this.timerId = null;
        this.state = {
            result: [],
            isShowResult: false,
        };

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick(e) {
        let elements = [];
        let value = e.target.value;
        let timerTime = 1000;
        const url = config.restCatalog + "?ProductSearchForm[name]=" + value+'&expand=backendHref';

        if (this.timerId) clearTimeout(this.timerId);


        this.timerId = setTimeout(() => {
            fetch(url).then(response => response.json()).then(commits => {
                this.renderResult(commits)
            });
        }, timerTime);
    }



    renderResult(elements) {
        this.setState({
            result: elements,
            isShowResult: true
        });
    }

    render() {
        return (
            <div className="search-admin">
                <div className="search-form-container">

                    <form className="search-form">
                        <input className="search-form__input" name="search" placeholder="Поиск по сайту..." onChange={this.handleClick}/>
                    </form>

                    <Result isNeedShow={this.state.isShowResult} result={this.state.result}/>

                </div>
            </div>
        )

    }
}

export default Search;