import React, {Component} from "react";
import Error from "../html/Error";

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
        let error, aria_invalid;

        if (typeof this.props.errors === 'object' && !Array.isArray(this.props.errors)) {
            error = <Error errors={this.props.errors['time']}/>
            aria_invalid = this.props.errors['time'] !== undefined;
        }

        return (
            <label className="checkout-form__label" htmlFor="checkout-time-delivery">
                <div className="checkout-form__label-text">Время доставки*</div>
                <div className="form-group field-checkout-time-delivery required">
                    <label className="select" htmlFor="checkout-time-delivery" aria-invalid={aria_invalid}>
                        <select id="checkout-time-delivery" className="checkout-form__select" name="OrderDate[time]">
                            <option value="" disabled="disabled" selected="selected">Время доставки</option>
                            {this.state.items.map((element, key) => {
                                return <option key={key} value={element}>{element}</option>;
                            })}
                        </select>
                        <svg>
                            <use xlinkHref="#select-arrow-down"/>
                        </svg>
                    </label>
                    <svg className="sprites">
                        <symbol id="select-arrow-down" viewBox="0 0 10 6">
                            <polyline points="1 1 5 5 9 1"/>
                        </symbol>
                    </svg>

                    {error}
                </div>
            </label>

        );
    }
}

export default TimeDeliveryField;