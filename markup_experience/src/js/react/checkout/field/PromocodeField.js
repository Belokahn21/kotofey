import React, {Component} from "react";
import config from "../../../config";

class PromocodeField extends Component {
    constructor(props) {
        super(props);
        this.timerEx = null, this.timeToStart = 300;
    }

    handlePromocode(event) {
        let element = event.target;
        let promocode = element.value;

        if (this.timerEx) clearTimeout(this.timerEx);

        this.timerEx = setTimeout(() => {
            fetch(config.restPromocodeGet + '/' + promocode + '/').then(response => response.json()).then(data => {
            })
        }, this.timeToStart)
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div>Промокод</div>
                <div className="form-group field-order-promocode has-success">
                    <input type="text" id="order-promocode" onKeyDown={this.handlePromocode.bind(this)} className="checkout-form__input js-validate-promocode" name="Order[promocode]" placeholder=""/>
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