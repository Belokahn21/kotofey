import React, {Component} from "react";

class PromocodeField extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div>Промокод</div>
                <div className="form-group field-order-promocode has-success">
                    <input type="text" id="order-promocode" className="checkout-form__input js-validate-promocode" name="Order[promocode]" placeholder=""/>
                    <input type="hidden" className="js-promocode-amount" name="promocode-discount"/>
                    <div className="checkout-form-promocode">Ваш промокод: <span className="checkout-form-promocode__code"/>
                        <span className="checkout-form-promocode__discount"></span>
                    </div>
                    <p className="help-block help-block-error"/>
                </div>
            </label>
        );
    }
}

export default PromocodeField;