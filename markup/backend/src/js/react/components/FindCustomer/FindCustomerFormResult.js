import React from "react";
import ReactDom from "react-dom";
import {Form, Modal} from "react-bootstrap";

class FindCustomerFormResult extends React.Component {

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
        const {items} = this.props;
        return (
            <div>
                {items.map((el, i) => {
                    console.log(el);
                    console.log(i);
                })}
            </div>
        );
    }

}