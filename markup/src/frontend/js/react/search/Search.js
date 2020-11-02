import React from "react";
import ReactDom from "react-dom";
import config from "../../../../backend/js/reactjs/config";
import BuildQuery from "../../tools/BuildQuery";

class Search extends React.Component {
    constructor() {
        super();

        this.timeoutExt = null;
        this.timeout = 300;

        this.state = {
            variants: []
        };
    }

    handleSearchInput(event) {
        if (this.timeoutExt) clearTimeout(this.timeoutExt);

        let element = event.target;

        console.log(element);
        console.log(element.value);

        this.timeoutExt = setTimeout(() => {

            fetch(config.restCatalogGet + '?' + BuildQuery.formatObject({name: element.value})).then(response => response.json()).then(data => {

                this.setState({
                    variants: data
                });

            });

        }, this.timeout)
    }

    render() {
        return <form className="search-form">
            <div className="search-form__input-group">
                <button className="search-form__button">
                    <img className="search-form__icon" src="./assets/images/search.png"/>
                </button>
                <input className="search-form__input js-live-search" onKeyUp={this.handleSearchInput.bind(this)} name="q"/>
            </div>
            <div className="list-variants">
                {this.state.variants.map(el => {
                    return <div className="list-variants__item">
                        <a href={el.href}>{el.name}</a>
                    </div>
                })}
            </div>
        </form>
    }
}


const search = document.querySelector('.search-react');
if (search) {
    ReactDom.render(<Search/>, search);
}