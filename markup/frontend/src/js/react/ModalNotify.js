import React from 'react';
import {Modal} from "react-bootstrap";

class ModalNotify extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const {show, message, handleCloseNotify} = this.props;

        return <Modal show={show} onHide={handleCloseNotify}>
            <Modal.Header closeButton>

            </Modal.Header>
            <Modal.Body className="modal-notify-text">
                {message}
            </Modal.Body>
        </Modal>
    }
}

export default ModalNotify;