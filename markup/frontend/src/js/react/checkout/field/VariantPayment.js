import React, {Component} from 'react';
import Error from "../html/Error";

class VariantPayment extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const elements = this.props.models, exclude = this.props.exclude;
        let error, aria_invalid;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors['payment_id']}/>
            aria_invalid = this.props.errors['payment_id'] !== undefined;
        }
        return <div className="checkout-form-variants-wrapper">
            <div className="checkout-form-variants">
                {elements.filter(element => !exclude.includes(element.id)).map((element, key) => {
                    const uniq = Math.random().toString(36).substring(7) + element.id + 'p'
                    return <div className="checkout-form-variants__item-wrap" key={key}>
                        <div className="checkout-form-variants__item">
                            <input onChange={this.props.handleSelectPayment.bind(this)} className="checkout-form-variants__input" type="radio" id={uniq} name={this.props.modelName + '[payment_id]'} defaultValue={element.id}/>
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
        </div>
    }
}

export default VariantPayment;