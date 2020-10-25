import React from 'react';
import ReactDom from "react-dom";

import config from "../../../../backend/js/reactjs/config";

class CdekCalculator extends React.Component {

    constructor() {
        super();

        this.handleInputCityTimerId = null;

        this.state = {
            summary: 0,
            cities: []
        };
    }

    handleSumbmitForm(event) {
        event.preventDefault();
        console.log("Форма отправлена");

        fetch(config.restCdekDeliveryPrice).then(response => response.json()).then(data => {
            data = JSON.parse(data);
            if (data.result.price) {
                this.setState({
                    summary: data.result.price
                });
            }
        });
    }

    handleInputCity(event) {
        let element = event.target;

        if (this.handleInputCityTimerId) {
            clearTimeout(this.handleInputCityTimerId)
        }

        this.handleInputCityTimerId = setTimeout(() => {
            fetch(config.restCdekCity + '?name=' + element.value).then(response => response.json()).then(data => {
                this.setState({
                    cities: data
                });
            });

            console.log(this.state.cities);
        }, 1000);
    }

    render() {
        return <form className="form-delivery-calc" onSubmit={this.handleSumbmitForm = this.handleSumbmitForm.bind(this)}>
            <div className="form-delivery-calc__row">
                <div className="form-delivery-calc__col x-1-2">
                    <div className="title">Приблизительная стоимость доставки</div>
                    <div className="sub-title">Доставка осуществляется транспортной компанией до двери либо до склада</div>
                    <div className="form-delivery-calc__element">
                        <div className="form-delivery-calc-dropdown-wrap">
                            <input className="form-delivery-calc__input" onKeyUp={this.handleInputCity.bind(this)} type="text" required placeholder="Куда доставить?"/>
                            <div className="form-delivery-calc-dropdown">
                                {this.state.cities.map(city => {
                                    return <div className="form-delivery-calc-dropdown__item">{city.FullName}</div>
                                })}
                            </div>
                        </div>
                        <input type="hidden" name="city_id"/>
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