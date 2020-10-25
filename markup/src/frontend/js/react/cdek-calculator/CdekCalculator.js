import React from 'react';
import ReactDom from "react-dom";

import config from "../../../../backend/js/reactjs/config";
import BuildQuery from '../../tools/BuildQuery';

class CdekCalculator extends React.Component {

    constructor() {
        super();

        this.handleInputCityTimerId = null;

        this.state = {
            error: "",
            summary: 0,
            cities: [],
            sizes: []
        };


        fetch(config.restCdekSize).then(response => response.json()).then(data => {
            this.setState({
                sizes: data
            });
        });
    }

    handleSumbmitForm(event) {
        event.preventDefault();

        fetch(config.restCdekDeliveryPrice + '?' + BuildQuery.format(event.target)).then(response => response.json()).then(data => {
            if (data.result !== undefined) {
                this.setState({
                    summary: data.result.price,
                    error: null
                });
            }

            if(data.error !== undefined){
                this.setState({
                    error: data.error[0].text,
                    summary: 0,
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
        }, 1000);
    }

    handleClickCityItem(event) {
        let element = event.target, form = document.querySelector('.form-delivery-calc');

        if (!form) {
            return false;
        }
        form.querySelector('#form-delivery-calc-city').value = element.textContent;
        form.querySelector('input[name=get_city_id]').value = element.getAttribute('data-city-id');
        form.querySelector('input[name=get_postcode]').value = element.getAttribute('data-postcode');
        this.setState({
            cities: []
        })
    }

    getPostcode(postcode) {
        let splitCode = postcode.split(',');
        if (splitCode.length > 1) {
            return splitCode[0];
        }
        return postcode;
    }

    render() {
        return <form className="form-delivery-calc" onSubmit={this.handleSumbmitForm = this.handleSumbmitForm.bind(this)}>
            <div className="form-delivery-calc__row">
                <div className="form-delivery-calc__col x-1-2">
                    <div className="title">Приблизительная стоимость доставки</div>
                    <div className="sub-title">Доставка осуществляется транспортной компанией до двери либо до склада</div>
                    <div className="form-delivery-calc__element">
                        <div className="form-delivery-calc-dropdown-wrap">
                            <input className="form-delivery-calc__input" id="form-delivery-calc-city" onKeyUp={this.handleInputCity.bind(this)} type="text" required placeholder="Куда доставить?"/>
                            <div className="form-delivery-calc-dropdown">
                                {this.state.cities.map((city, index) => {
                                    return <div onClick={this.handleClickCityItem.bind(this)} key={index} data-postcode={this.getPostcode(city.postcode)} data-city-id={city.city_id} className="form-delivery-calc-dropdown__item">{city.FullName}</div>
                                })}
                            </div>
                        </div>
                        <input type="hidden" name="get_city_id"/>
                        <input type="hidden" name="get_postcode"/>
                    </div>
                    <div className="form-delivery-calc__element">
                        <select required name="size" className="form-delivery-calc__select">
                            <option>Примерный вид посылки</option>
                            {this.state.sizes.map((size, index) => {
                                return <option key={index} value={size.id}>{size.name}</option>
                            })}
                        </select>
                    </div>
                    {/*<div className="form-delivery-calc__element">*/}
                    {/*    <select className="form-delivery-calc__select">*/}
                    {/*        <option>Место получения</option>*/}
                    {/*        <option>Склад</option>*/}
                    {/*        <option>До двери</option>*/}
                    {/*    </select>*/}
                    {/*</div>*/}
                </div>
                <div className="form-delivery-calc__col x-1-2">
                    <div className="summary-container">
                        <div className="sub-title">Ориентировочная стоимость достави:</div>
                        <div className="summary">{this.state.summary} Р</div>
                    </div>
                </div>
            </div>
            <div className="form-delivery-calc-error">{this.state.error}</div>
            <button className="form-delivery-calc__submit" type="submit">Рассчитать</button>
        </form>
    }
}


const formDeliveryCalc = document.querySelector('.form-delivery-calc-react');
if (formDeliveryCalc) {
    ReactDom.render(<CdekCalculator/>, formDeliveryCalc);
}