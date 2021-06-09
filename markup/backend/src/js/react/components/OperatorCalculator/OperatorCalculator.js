import React from 'react';
import ReactDom from 'react-dom';
import CalculatorDeliveryService from "./CalculatorDeliveryService";
import CalculatorProducts from "./CalculatorProducts";
import CalculatorResult from "./CalculatorResult";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";

class OperatorCalculator extends React.Component {
    constructor() {
        super();

        let img_src = '/images/tk/';
        this.state = {
            editable: true,
            services: [{name: 'cdek', src: `${img_src}cdek.jpg`, value: 'cdek'}, {name: 'ru_post', src: `${img_src}ru_post.png`, value: 'ru_post'}, {name: 'dpd', src: `${img_src}dpd.png`, value: 'dpd'}]
        };
    }

    handleFormSubmit(e) {
        e.preventDefault();
        let form = e.target;

        RestRequest.post(config.restDeliveryCalculate, {
            body: new FormData(form),
        }).then(data => {
            console.log(data);
        });
    }

    handleSelectService(e) {
        this.setState({editable: false})
    }

    render() {
        const {services, editable} = this.state;
        return <form className="calc-form" onSubmit={this.handleFormSubmit.bind(this)}>

            <button className="calc-form__submit" type="submit">Расчитать</button>

            <CalculatorDeliveryService handleSelectService={this.handleSelectService.bind(this)} items={services}/>

            <div className="calc-placement">
                <div className="calc-placement__from"><input type="text" readOnly={editable} name="placement_from" placeholder="Место отправки"/></div>
                <div className="calc-placement__to"><input type="text" readOnly={editable} name="placement_to" placeholder="Место доставки"/></div>
            </div>

            <div className="calc-panel">
                <CalculatorProducts/>
                <CalculatorResult/>
            </div>
        </form>
    }
}

let init = document.querySelectorAll('.operator-calculator-react');
if (init) init.forEach(el => {
    ReactDom.render(<OperatorCalculator/>, el);
});

