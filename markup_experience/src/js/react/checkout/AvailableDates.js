import React, {Component} from "react";

class AvailableDates extends Component {
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
            <select id="checkout-time-delivery" className="checkout-form__select" name="OrderDate[time]" aria-required="true">
                {this.state.items.map((element, key) => {
                    return <option key={key} value={element}>{element}</option>
                })}
            </select>
        );
    }
}

export default AvailableDates;