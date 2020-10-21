import React from 'react';
import ReactDom from "react-dom";

import config from "../../../../backend/js/reactjs/config";

class CdekCalculator extends React.Component {

    constructor() {
        super();

        this.state = {
            summary: 0
        };
    }

    handleSumbmitForm(event) {
        event.preventDefault();
        console.log("Форма отправлена");

        fetch(config.restCdekDeliveryPrice).then(response => response.json()).then(data => {
            data = JSON.parse(data);

            console.log(data);

            if (data.result.price) {
                this.setState({
                    summary: data.result.price
                });
            }
        });
    }

    render() {
        return <form className="form-delivery-calc" onSubmit={this.handleSumbmitForm = this.handleSumbmitForm.bind(this)}>
            <div className="form-delivery-calc__row">
                <div className="form-delivery-calc__col x-1-2">
                    <div className="title">Приблизительная стоимость доставки</div>
                    <div className="sub-title">Доставка осуществляется транспортной компанией до двери либо до склада</div>
                    <div className="form-delivery-calc__element">
                        <input className="form-delivery-calc__input" type="text" required placeholder="Куда доставить?"/>
                    </div>
                    <div className="form-delivery-calc__element">
                        <select className="form-delivery-calc__select">
                            <option>Примерный вид посылки</option>
                            <option>Пакет корма 12кг (39х25х17)</option>
                            <option>Пакет корма 12кг, наполнитель 20кг (58х50х34)</option>
                        </select>
                    </div>
                    <div className="form-delivery-calc__element">
                        <select className="form-delivery-calc__select">
                            <option>Место получения</option>
                            <option>Склад</option>
                            <option>До двери</option>
                        </select>
                    </div>
                </div>
                <div className="form-delivery-calc__col x-1-2">
                    <div className="summary-container">
                        <div className="sub-title">Ориентировочная стоимость достави:</div>
                        <div className="summary">{this.state.summary} Р</div>
                    </div>
                </div>
            </div>
            <button className="form-delivery-calc__submit" type="submit">Рассчитать</button>
        </form>
    }
}


const formDeliveryCalc = document.querySelector('.form-delivery-calc-react');
if (formDeliveryCalc) {
    ReactDom.render(<CdekCalculator/>, formDeliveryCalc);
}