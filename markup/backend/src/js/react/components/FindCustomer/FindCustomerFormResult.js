import React from "react";
import {array} from "prop-types";

class FindCustomerFormResult extends React.Component {

    constructor(props) {
        super(props);
        this.inputId = "demo sadasd asd ";
    }

    handleSelectCustomer(customer, event) {
        let element = event.target;

        let parentInput = document.querySelector('.load-customer-info__pid');
        if (parentInput && parentInput.value.length === 0) parentInput.value = customer.phone;


        customer.cross.map(el => {
            let input = document.querySelector('#order-' + el.code);

            if (input) {
                input.value = el.value;
            }
        });

    }

    render() {
        const {customer} = this.props;
        console.log(customer);
        if (!Array.isArray(customer)) {
            return (
                <div className="list-finds">
                    <div className="list-finds__item">
                        <a href="#" className="list-finds__link">{customer.name}</a>
                        <button type="button" onClick={this.handleSelectCustomer.bind(this, customer)}>Получить</button>
                    </div>
                </div>
            );
        } else {
            return <></>
        }
    }
}

export default FindCustomerFormResult;