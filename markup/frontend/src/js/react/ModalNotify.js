import React from 'react';
import {Modal} from "react-bootstrap";

class ModalNotify extends React.Component {
    constructor(props) {
        super(props);
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
        const {show, message} = this.props;

        return <Modal show={show} onHide={this.handleClose.bind(this)}>
            <Modal.Body className="modal-notify-text">
                {message}
            </Modal.Body>
        </Modal>
    }
}

export default ModalNotify;