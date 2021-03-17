import React, {Component} from 'react';

class VariantDelivery extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const element = this.props.element, uniq = Math.random().toString(36).substring(7) + element.id;
        return <div className="checkout-form-variants__item-wrap" key={uniq}>
            <div className="checkout-form-variants__item">
                <input onChange={this.props.handleSelectDelivery.bind(this)} className="checkout-form-variants__input" type="radio" id={uniq} name="delivery" defaultValue={element.id}/>
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

export default VariantDelivery;