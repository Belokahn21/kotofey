import React, {useState} from "react";
import {Modal, Button} from "react-bootstrap";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";


function NewProduct() {
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    function onShowModal() {
        // RestRequest.post(config.restOzon);
    }

    return (
        <>
            <Button variant="primary" onClick={handleShow}>
                Launch demo modal
            </Button>

            <Modal show={show} onHide={handleClose} onShow={onShowModal}>
                <Modal.Header closeButton>
                    <Modal.Title>Добавить товар</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    Woohoo, you're reading this text in a modal!


                </Modal.Body>


                <Modal.Footer>
                    <Button variant="secondary" onClick={handleClose}>
                        Close
                    </Button>
                    <Button variant="primary" onClick={handleClose}>
                        Save Changes
                    </Button>
                </Modal.Footer>


            </Modal>
        </>
    );
}

export default NewProduct;