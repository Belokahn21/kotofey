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
                <div className="eat-calculator-config-pet eat-calculator-config-block">


                    <label className="eat-calculator-config-pet__item">
                        <input name="pet" value="102" type="checkbox"/>
                        <div className="eat-calculator-config-pet__checked">
                            <i className="fas fa-check"/>
                        </div>
                        <img src="./assets/images/pet/dog.png"/>
                    </label>


                    <label className="eat-calculator-config-pet__item">
                        <input name="pet" value="101" type="checkbox"/>
                        <div className="eat-calculator-config-pet__checked">
                            <i className="fas fa-check"/>
                        </div>
                        <img src="./assets/images/pet/cat.png"/>
                    </label>

                </div>

                <div className="eat-calculator-config__age eat-calculator-config-block">
                    <div className="filter-catalog-checkboxes__item">
                        <input type="checkbox" name="age"/>
                        <label htmlFor="filter-chb-1"><i className="fas fa-paw" aria-hidden="true"/>До года</label>
                    </div>
                    <div className="filter-catalog-checkboxes__item">
                        <input type="checkbox" name="age"/>
                        <label htmlFor="filter-chb-1"><i className="fas fa-paw" aria-hidden="true"/>Больше года</label>
                    </div>
                    <div className="filter-catalog-checkboxes__item">
                        <input type="checkbox" name="age"/>
                        <label htmlFor="filter-chb-1"><i className="fas fa-paw" aria-hidden="true"/>Старше 7 лет</label>
                    </div>
                </div>

                <div className="eat-calculator-config__weight eat-calculator-config-block">
                    <input type="text" placeholder="Вес вашего питомца"/>
                </div>

                <div className="eat-calculator-config__activity eat-calculator-config-block">
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