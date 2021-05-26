import React from "react";
import ReactDom from "react-dom";
import {Form, Modal} from "react-bootstrap";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";
import Button from "../FindProduct/Button";

class FindCustomerForm extends React.Component {

    constructor(props) {
        super(props);
        // this.state = {
        // customer: null,
        // show: false
        // }
    }

    // setShow(show) {
    //     this.setState({show: show});
    // }
    //
    // handleClose() {
    //     this.setShow(false);
    // }
    //
    // handleShow() {
    //     this.setShow(true);
    // }

    handleTypingText(event) {
        let input = event.target;
        RestRequest.one(config.restOrderCustomer, input.value).then(data => {
            console.log(data);
        });
    }

    render() {
        return (
            <form className="form-finds">
                <input className="form-finds__input" onKeyUp={this.handleTypingText.bind(this)} placeholder="Телефон клиента в формате 8хххххххх"/>
            </form>
        );
    }

}

export default FindCustomerForm;