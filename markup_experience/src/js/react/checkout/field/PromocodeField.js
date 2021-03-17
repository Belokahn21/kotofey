import React, {Component} from "react";
import config from "../../../config";
import RestRequest from "../../../tools/RestRequest";

class PromocodeField extends Component {
    constructor(props) {
        super(props);
        this.timerEx = null, this.timeToStart = 800;

    }

    handlePromocode(event) {
        let element = event.target;
        let promocode = element.value;

        if (this.timerEx) clearTimeout(this.timerEx);

        this.timerEx = setTimeout(() => {
            RestRequest.one(config.restPromocode, promocode).then(data => {
                if (parseInt(data.status) === 200) {
                    this.props.updatePoromocode(data.item);
                    this.props.refreshBasket();
                    this.setState({promocode: data.item});
                }
            });
        }, this.timeToStart)
    }

    render() {
        let promocode = this.props.promocode;
        let promocodeSuccess = "";
        if (promocode !== null) {
            promocodeSuccess = <div className="checkout-form-promocode">Ваш промокод: <span className="checkout-form-promocode__code">{promocode.code} -{promocode.discount}%</span>
                <span className="checkout-form-promocode__discount"/>
            </div>;
        }

        return (
            <label className="checkout-form__label" htmlFor="checkout-phone">
                <div className="checkout-form__label-text">Промокод</div>
                <div className="form-group field-order-promocode has-success">
                    <input type="text" id="order-promocode" onKeyUp={this.handlePromocode.bind(this)} className="checkout-form__input js-validate-promocode" name="Order[promocode]" placeholder=""/>
                    <input type="hidden" className="js-promocode-amount" name="promocode-discount"/>
                    {promocodeSuccess}
                    <p className="help-block help-block-error"/>
                </div>
            </label>
        );
    }
}

export default PromocodeField;