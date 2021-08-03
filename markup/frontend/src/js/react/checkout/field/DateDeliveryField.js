import React, {Component} from "react";

class DateDeliveryField extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        let availableDates = ['04-25-2021', '04-27-2021', '04-22-2021'];
        $(this.refs.datepicker).datepicker({
            autoClose: true,
            startDate: '07/03/2013',
            beforeShow: function (e) {
                alert('demo 2');
                console.log('demo 2');
                console.log(e);
            },
            beforeShowDay: function (d) {
                alert('demo');
                console.log('demo');
            }
            // beforeShowDay: function (d) {
            //     var dmy = (d.getMonth() + 1)
            //     if (d.getMonth() < 9)
            //         dmy = "0" + dmy;
            //     dmy += "-";
            //
            //     if (d.getDate() < 10) dmy += "0";
            //     dmy += d.getDate() + "-" + d.getFullYear();
            //
            //     console.log(dmy + ' : ' + ($.inArray(dmy, availableDates)));
            //
            //     if ($.inArray(dmy, availableDates) != -1) {
            //         return [true, "", "Available"];
            //     } else {
            //         return [false, "", "unAvailable"];
            //     }
            // }
        });
    }

    render() {
        return (
            <label className="checkout-form__label" htmlFor="checkout-date-delivery">
                <div className="checkout-form__label-text">Дата доставки*</div>
                <div className="form-group field-checkout-date-delivery required">
                    <input type="text" id="checkout-date-delivery" ref="datepicker" className="checkout-form__input" name="OrderDate[date]" placeholder="Дата доставки" data-min="1614546000"/>
                    <p className="help-block help-block-error"/>
                </div>
            </label>
        );
    }
}

export default DateDeliveryField;