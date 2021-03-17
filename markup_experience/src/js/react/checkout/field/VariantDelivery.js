import React, {Component} from 'react';
import Error from "../html/Error";

class VariantDelivery extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const elements = this.props.models;
        let error, aria_invalid;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors['delivery_id']}/>
            aria_invalid = this.props.errors['delivery_id'] !== undefined;
        }

        return <div className="checkout-form-variants-wrapper">
            <div className="checkout-form-variants">
                {elements.map((element, key) => {
                    const uniq = Math.random().toString(36).substring(7) + element.id + 'd';
                    return <div className="checkout-form-variants__item-wrap" key={key}>
                        <div className="checkout-form-variants__item">
                            <input onChange={this.props.handleSelectDelivery.bind(this)} className="checkout-form-variants__input" type="radio" id={uniq} name={this.props.modelName + '[delivery_id]'} defaultValue={element.id}/>
                            <label className="checkout-form-variants__label" htmlFor={uniq}>
                                <div className="checkout-form-variants__text-container">
                                    <div className="checkout-form-variants__title">{element.name}</div>
                                    <div className="checkout-form-variants__description">{element.description}</div>
                                </div>
                                <img className="checkout-form-variants__image" src={element.imageUrl}/></label>
                        </div>
                    </div>
                })}
            </div>
            {error}
        </div>;
    }
}

export default VariantDelivery;