import React from "react";
import ReactDom from "react-dom";
import config from "../../../../backend/js/reactjs/config";
import BuildQuery from "../../tools/BuildQuery";
import ResultSearch from './ResultSearch';

class Search extends React.Component {
    constructor(props) {
        super(props);

        this.timeoutExt = null;
        this.timeout = 300;

        this.searchText = null;
        if (props.options) this.searchText = JSON.parse(props.options).searchText;

        this.state = {
            variants: []
        };
    }

    handleSearchInput(event) {
        if (this.timeoutExt) clearTimeout(this.timeoutExt);
        let element = event.target;


        if (element.value.length === 0) {
            this.setState({
                variants: []
            });
        } else {
            this.timeoutExt = setTimeout(() => {
                fetch(config.restCatalogFrontGet + '?' + BuildQuery.formatObject({name: element.value})).then(response => response.json()).then(data => {
                    this.setState({
                        variants: data
                    });
                });
            }, this.timeout)
        }
    }

    render() {
        return <form className={this.state.variants.length > 0 ? "search-form filled" : "search-form"} action='/search/'>
            <div className="search-form__input-group">
                <button className="search-form__button">
                    <img alt="Поиск" className="search-form__icon" src="/upload/images/search.svg"/>
                </button>
                {this.searchText
                    ? <input defaultValue={this.searchText} className="search-form__input js-live-search" onKeyUp={this.handleSearchInput.bind(this)} name="Search[search]"/>
                    : <input className="search-form__input js-live-search" onKeyUp={this.handleSearchInput.bind(this)} name="Search[search]"/>}

            </div>
            <ResultSearch items={this.state.variants}/>
        </form>
    }
}


const search = document.querySelector('.search-react');
if (search) {
    ReactDom.render(<Search options={search.getAttribute('data-options')}/>, search);
}