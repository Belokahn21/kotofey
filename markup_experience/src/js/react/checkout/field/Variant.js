import React, {Component} from 'react';

class Variant extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        let element = this.props.element;
        return <div className="checkout-form-variants__item-wrap" key={element.id}>
            <div className="checkout-form-variants__item">
                <input className="checkout-form-variants__input" type="radio" id={"delivery" + element.id} name="delivery" defaultValue={element.id}/>
                <label className="checkout-form-variants__label" htmlFor={"delivery" + element.id}>
                    <div className="checkout-form-variants__text-container">
                        <div className="checkout-form-variants__title">{element.name}</div>
                        <div className="checkout-form-variants__description">{element.description}</div>
                    </div>
                    <img className="checkout-form-variants__image" src={element.imageUrl}/></label>
            </div>
        </div>
    }
}

export default Variant;