import React from 'react';
import Error from "../Error";

class Variants extends React.Component {
    constructor(props) {
        super(props);
    }

    handleChange(e) {
        this.props.unsetError(this.props.attribute);
        this.props.handlerSelect(e);
    }

    render() {
        const elements = this.props.models;
        let error, aria_invalid;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors[this.props.attribute]}/>
            aria_invalid = this.props.errors[this.props.attribute] !== undefined;
        }

        return <div className="checkout-form-variants-wrapper">
            <div className="checkout-form-variants">
                {elements.map((element, key) => {
                    const uniq = Math.random().toString(36).substring(7) + element.id + this.props.attribute;
                    return <div className="checkout-form-variants__item-wrap" key={key}>
                        <div className="checkout-form-variants__item">
                            <input onChange={this.handleChange.bind(this)} className="checkout-form-variants__input" type="radio" id={uniq} name={this.props.modelName + '[' + this.props.attribute + ']'} defaultValue={element.id}/>
                            <label className="checkout-form-variants__label" htmlFor={uniq} aria-invalid={aria_invalid}>
                                <div className="checkout-form-variants__text-container">
                                    <div className="checkout-form-variants__title">{element.name}</div>
                                    <div className="checkout-form-variants__description">{element.description}</div>
                                </div>
                                <img className="checkout-form-variants__image" src={element.imageUrl}/>
                            </label>
                        </div>
                    </div>
                })}
            </div>
            {error}
        </div>;
    }
}

export default Variants;