import React from "react";
import ReactDom from "react-dom";

class Search extends React.Component {
    constructor() {
        super();
    }

    render() {
        return <form className="search-form">
            <div className="search-form__input-group">
                <button className="search-form__button"><img className="search-form__icon" src="./assets/images/search.png"/></button>
                <input className="search-form__input js-live-search" name="q"/>
            </div>
        </form>
    }
}


const search = document.querySelector('.search-react');
if (search) {
    ReactDom.render(<Search/>, search);
}