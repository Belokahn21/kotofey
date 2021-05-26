import React from "react";

class FindCustomerFormResult extends React.Component {

    constructor(props) {
        super(props);
        this.inputId = "demo sadasd asd ";
    }

    render() {
        const {customer} = this.props;
        return (
            <div className="list-finds">
                <div className="list-finds__item">
                    <a href="#" className="list-finds__link">{customer.name}</a>
                </div>
            </div>
        );
    }
}

export default FindCustomerFormResult;