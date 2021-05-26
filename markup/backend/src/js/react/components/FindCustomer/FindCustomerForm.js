import React from "react";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import FindCustomerFormResult from "./FindCustomerFormResult";

class FindCustomerForm extends React.Component {

    constructor(props) {
        super(props);
        this.timerEx = false;
        this.timer = 1500;
        this.state = {
            customer: [],
        }
    }

    handleTypingText(event) {
        let input = event.target;
        if (this.timerEx) clearTimeout(this.timerEx);
        this.timerEx = setTimeout(() => {
            RestRequest.one(config.restOrderCustomer, input.value).then(data => {
                this.setState({customer: data})
            });
        }, this.timer);
    }

    render() {
        const {customer} = this.state;
        return (
            <>
                <form className="form-finds">
                    <input className="form-finds__input" onKeyUp={this.handleTypingText.bind(this)} placeholder="Телефон клиента в формате 8хххххххх"/>
                </form>

                <FindCustomerFormResult customer={customer}/>
            </>
        );
    }

}

export default FindCustomerForm;