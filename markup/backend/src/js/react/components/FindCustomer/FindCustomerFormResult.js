import React from "react";

class FindCustomerFormResult extends React.Component {

    constructor(props) {
        super(props);
        this.inputId = "demo sadasd asd ";
    }

    handleSelectCustomer(customer, event) {
        let currentElement = event.target;

        let parentInput = document.querySelector('.load-customer-info__pid');
        if (parentInput && parentInput.value.length === 0) parentInput.value = customer.phone;


        Object.keys(customer.cross).map(key => {
            let element = document.querySelector('#order-' + key)
            if (element) element.value = customer.cross[key];
        })

    }

    render() {
        const {customer} = this.props;
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