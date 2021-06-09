import React from 'react';

class CalculatorDeliveryService extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {items} = this.props;
        return (
            <div className="calc-delivery-services">
                {items.map(el => {
                    return <label className="calc-delivery-services__label">
                        <input name="service" className="calc-delivery-services__input" type="radio" value={el.value}/>
                        <div className="calc-delivery-services__item">
                            <img src={el.src} alt={el.name} title={el.name} className="calc-delivery-services__image"/>
                        </div>
                    </label>
                })}
            </div>
        );
    }
}

export default CalculatorDeliveryService;