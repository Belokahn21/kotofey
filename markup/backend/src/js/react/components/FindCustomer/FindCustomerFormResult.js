import React from "react";

class FindCustomerFormResult extends React.Component {

    constructor(props) {
        super(props);
        this.inputId = "demo sadasd asd ";
    }



    render() {
        const {customer} = this.props;
        if (!Array.isArray(customer)) {
            return (
                <div className="list-finds">
                    <div className="list-finds__item">
                        <a href="#" className="list-finds__link">{customer.phone} / {customer.name}</a>
                        <button className="list-finds__setup" type="button" onClick={this.props.handleSelectCustomer.bind(this, customer)}>Выбрать</button>
                    </div>
                </div>
            );
        } else {
            return <></>
        }
    }
}

export default FindCustomerFormResult;