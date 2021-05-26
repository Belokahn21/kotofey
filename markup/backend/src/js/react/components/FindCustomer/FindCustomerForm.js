import React from "react";
import ReactDom from "react-dom";
import {Form, Modal} from "react-bootstrap";

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
    }

    render() {
        return (
            <Form>
                <input type="text" onChange={this.handleTypingText.bind(this)} placeholder="Телефон клиента"/>
            </Form>
        );
    }

}