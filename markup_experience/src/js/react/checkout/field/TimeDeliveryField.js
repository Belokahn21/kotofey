import React, {Component} from "react";

class TimeDeliveryField extends Component {
    constructor() {
        super();

        let dates = [];
        for (let i = 1; i <= 15; i++) {
            let dateRow = new Date(2021, 1, i);
            dates[i] = dateRow.toLocaleDateString();
        }

        this.state = {
            items: dates,
        };
    }


    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-time-delivery">
                <div className="checkout-form__label-text">Время доставки*</div>
                <div className="form-group field-checkout-time-delivery required">
                    <select id="checkout-time-delivery" className="checkout-form__select" name="OrderDate[time]" aria-required="true">
                        {this.state.items.map((element, key) => {
                            return <option key={key} value={element}>{element}</option>
                        })}
                    </select>
                    <p className="help-block help-block-error"/>
                </div>
            </label>

        );
    }
}

export default TimeDeliveryField;