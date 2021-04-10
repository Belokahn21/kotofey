import React from 'react';

import config from '../../config';
import Button from './Button';
import BuildQuery from "../../../../../../frontend/src/js/tools/BuildQuery";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";

class FindProductForm extends React.Component {
    constructor(props) {
        super(props);

        this.timerEx = null;
        this.timeTimer = 400;
        this.inputId = props.inputId;

        this.state = {
            items: []
        };
    }

    isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    handleInput(e) {
        if (this.timerEx) clearTimeout(this.timerEx);
        const element = e.target, value = element.value;

        let queyParam = '?ProductSearchForm[name]=';

        if (this.isNumeric(value)) queyParam = '?ProductSearchForm[code]=';

        this.timerEx = setTimeout(() => {
            RestRequest.all(config.restCatalog + queyParam + value).then(result => {
                this.setState({
                    items: result
                });
            });
        }, this.timeTimer);
    }

    render() {
        return <form className="form-finds">
            <input className="form-finds__input" onKeyUp={this.handleInput.bind(this)} placeholder="Название для поиска"/>

            <div className="list-finds">
                {this.state.items.map((el, index) => {
                    return <div className="list-finds__item" key={index}>
                        <a href="#" className="list-finds__link">{el.name}</a>
                        <Button productId={el.id} inputId={this.inputId}/>
                    </div>
                })}
            </div>
        </form>;
    }
}

export default FindProductForm;