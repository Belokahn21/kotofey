import React, {Component} from 'react';

class VariantPayment extends Component {
    constructor(props) {
        super(props);
    }

    testFunc() {
        console.log("as");
    }

    render() {
        const element = this.props.element, uniq = Math.random().toString(36).substring(7) + element.id + 'p';
        return <div className="checkout-form-variants__item-wrap">
            <div className="checkout-form-variants__item">
                <input onSelect={this.testFunc.bind(this)} className="checkout-form-variants__input" type="radio" id={uniq} name="Order[payment_id]" defaultValue={element.id}/>
                <label className="checkout-form-variants__label" htmlFor={uniq}>
                    <div className="checkout-form-variants__text-container">
                        <div className="checkout-form-variants__title">{element.name}</div>
                        <div className="checkout-form-variants__description">{element.description}</div>
                    </div>
                    <img className="checkout-form-variants__image" src={element.imageUrl}/></label>
            </div>
        </div>
    }
}

export default VariantPayment;