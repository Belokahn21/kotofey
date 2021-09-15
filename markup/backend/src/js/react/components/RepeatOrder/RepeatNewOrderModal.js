import React from "react";
import {Modal} from "react-bootstrap";
import RepeatOrderItems from "./RepeatOrderItems";
import RepeatForm from "./RepeatForm";

class RepeatNewOrderModal extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false,
        };
    }

    setShow(show) {
        this.setState({show: show});
    }

    handleClose() {
        this.setShow(false);
    }

    handleShow() {
        this.setShow(true);
    }

    render() {
        const {order} = this.props;
        const {show} = this.state;
        return (
            <>
                <button className="repeat-order-list-item__do-action" type="button" onClick={this.handleShow.bind(this)}>Повторить</button>


                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Повторить заказ</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <RepeatForm order={order}/>
                    </Modal.Body>
                </Modal>
            </>
        );
    }

}

export default RepeatNewOrderModal;