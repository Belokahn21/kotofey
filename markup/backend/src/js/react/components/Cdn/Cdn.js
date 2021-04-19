import React from 'react';
import ReactDOM from 'react-dom';
import {Modal} from "react-bootstrap";
import FindProductForm from "../FindProduct/FindProductForm";

class Cdn extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            show: false
        };
        this.modalId = Math.random().toString(36).substring(7);
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
        const {show} = this.state;
        return (
            <div>
                <button type="button" onClick={this.handleShow.bind(this)} className="btn-main">Выбрать</button>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Выбрать медиа из CDN</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        nsasdd alsd aasn ddas asad dans adals sads nals
                    </Modal.Body>
                </Modal>
            </div>
        );
    }
}

const element = document.querySelector('.cdn-modal-react');
if (element) ReactDOM.render(<Cdn/>, element);