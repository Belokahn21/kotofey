import React from 'react';

import config from '../../config';
import Button from './Button';
import Price from "../../../../../../frontend/src/js/tools/Price";
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

        let queryParam = '?expand=imageUrl,discount_price,backendHref&ProductSearchForm[mixed_value]=';

        this.timerEx = setTimeout(() => {
            RestRequest.all(config.restCatalog + queryParam + value).then(result => {
                this.setState({
                    items: result
                });
            });
        }, this.timeTimer);
    }

    render() {
        return <form className="form-finds">
            <input className="form-finds__input" onKeyUp={this.handleInput.bind(this)} placeholder="Поиск по названию, артикулу, внешнему коду"/>

            <div className="list-finds">
                {this.state.items.map((el, index) => {
                    return <div className="list-finds__item" key={index}>
                        <a href={el.imageUrl} data-lightbox="roadtrip"><img src={el.imageUrl} className="list-finds__image"/></a>
                        <a href={el.backendHref} target="_blank" className="list-finds__link">{el.name}</a>
                        <div className="list-finds-data">
                            <div className="list-finds-data__row">
                                <div className="list-finds-data__key">Цена</div>
                                <div className="list-finds-data__value">{Price.format(el.price)}</div>
                            </div>
                            {!el.discount_price ? '' :
                                <div className="list-finds-data__row">
                                    <div className="list-finds-data__key">Со скидкой</div>
                                    <div className="list-finds-data__value">{Price.format(el.discount_price)}</div>
                                </div>}
                            <div className="list-finds-data__row">
                                <div className="list-finds-data__key">Кол-во</div>
                                <div className="list-finds-data__value">{el.count}</div>
                            </div>
                        </div>
                        <Button productId={el.id} inputId={this.inputId}/>
                    </div>
                })}
            </div>
        </form>;
    }
}

export default FindProductForm;