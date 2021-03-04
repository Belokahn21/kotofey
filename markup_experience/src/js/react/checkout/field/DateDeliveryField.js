import React,{Component} from "react";
class DateDeliveryField extends Component{
    constructor(props) {
        super(props);
    }

    render() {
        return(
            <label className="checkout-form__label" htmlFor="checkout-date-delivery">
                <div>Дата доставки*</div>
                <div className="form-group field-checkout-date-delivery required">
                    <input type="text" id="checkout-date-delivery" className="js-datepicker checkout-form__input" name="OrderDate[date]" placeholder="Дата доставки" data-min="1614546000" />
                    <p className="help-block help-block-error"/>
                </div>
            </label>
        );
    }
}

export default DateDeliveryField;