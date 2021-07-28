import React from 'react';
import ReactDom from 'react-dom';
import CalculatorDeliveryService from "./CalculatorDeliveryService";
import CalculatorProducts from "./CalculatorProducts";
import CalculatorResult from "./CalculatorResult";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import FormLocation from "./FormLocation";

class OperatorCalculator extends React.Component {
    constructor() {
        super();

        let img_src = '/images/tk/';
        this.state = {
            tariff_list: [],
            services: [{name: 'cdek', src: `${img_src}cdek.jpg`, value: 'cdek'}, {name: 'ru_post', src: `${img_src}ru_post.png`, value: 'ru_post'}, {name: 'dpd', src: `${img_src}dpd.png`, value: 'dpd'}]
        };
    }

    handleFormSubmit(e) {
        e.preventDefault();
        let form = e.target;

        RestRequest.post(config.restDeliveryCalculate, {
            body: new FormData(form),
        }).then(data => {
            this.setState({tariff_list: data});
        });
    }

    render() {
        const {services, tariff_list} = this.state;
        return <>
            <form className="calc-form" onSubmit={this.handleFormSubmit.bind(this)}>

                <button className="calc-form__submit" type="submit">Расчитать</button>

                <CalculatorDeliveryService items={services}/>

                <div className="calc-placement">
                    <FormLocation options={{
                        name: 'placement_from',
                        placeholder: 'Место отправки',
                    }}/>
                    <FormLocation options={{
                        name: 'placement_to',
                        placeholder: 'Место доставки',
                    }}/>
                </div>

                <div className="calc-panel">
                    <CalculatorProducts/>
                    <CalculatorResult tariff_list={tariff_list}/>
                </div>
            </form>
        </>
    }
}

let init = document.querySelectorAll('.operator-calculator-react');
if (init) init.forEach(el => {
    ReactDom.render(<OperatorCalculator/>, el);
});

