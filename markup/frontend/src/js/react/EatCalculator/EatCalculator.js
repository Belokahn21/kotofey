import React from 'react';
import ReactDom from 'react-dom';

class EatCalculator extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            products: []
        }
    }

    render() {
        const {products} = this.state;
        return <div className="eat-calculator">
            <form className="eat-calculator-config">
                <div className="eat-calculator-config__pet">


                    <label>
                        <input name="pet" value="102"/>
                        <img src="./assets/images/pet/dog.jpg"/>
                    </label>


                    <label>
                        <input name="pet" value="101"/>
                        <img src="./assets/images/pet/cat.png"/>
                    </label>

                </div>

                <div className="eat-calculator-config__age">
                    <div> до 1</div>
                    <div> после 1</div>
                    <div> старше 7</div>
                </div>

                <div className="eat-calculator-config__weight">
                    <input type="text" placeholder="Вес вашего питомца"/>
                </div>

                <div className="eat-calculator-config__activity">
                    <div>Сидячий</div>
                    <div>Полу-подвижный</div>
                    <div>Подвижный</div>
                </div>
            </form>

            <div className="eat-calculator-result">
                {products.map((el, index) => {
                    <div className="eat-calculator-result__item">{el.name}</div>
                })}
            </div>
        </div>
    }

}

let elements = document.querySelectorAll('.eat-calculator-react');
if (elements) {
    elements.forEach(el => {
        ReactDom.render(<EatCalculator/>, el);
    });
}