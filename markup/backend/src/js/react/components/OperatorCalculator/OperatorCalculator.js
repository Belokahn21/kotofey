import React from 'react';
import ReactDom from 'react-dom';
import CalculatorDeliveryService from "./CalculatorDeliveryService";
import CalculatorProducts from "./CalculatorProducts";
import CalculatorResult from "./CalculatorResult";

class OperatorCalculator extends React.Component {
    constructor() {
        super();
    }

    render() {
        let img_src = '/images/tk/';
        return <form>
            <CalculatorDeliveryService items={[{name: 'cdek', src: `${img_src}cdek.jpg`, value: 'cdek'}, {name: 'ru_post', src: `${img_src}ru_post.png`, value: 'ru_post'}, {name: 'dpd', src: `${img_src}dpd.png`, value: 'dpd'}]}/>

            <div className="d-flex flex-row">
                <div><input type="text" name="placement_from" placeholder="Место отправки"/></div>
                <div><input type="text" name="placement_to" placeholder="Место доставки"/></div>
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

