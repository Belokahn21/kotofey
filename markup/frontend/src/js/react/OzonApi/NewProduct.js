import React, {useState} from "react";
import {Modal, Button} from "react-bootstrap";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import NewProductCategories from "./render/NewProductCategories";
import WaitLoader from "../WaitLoader";


function NewProduct() {
    const [show, setShow] = useState(false);
    const [categories, setCategories] = useState([]);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    function onShowModal() {
        RestRequest.post(config.restOzon).then(data => {
            setCategories(data);
        });
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
                    {categories ? <NewProductCategories models={categories}/> : <WaitLoader/>}
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