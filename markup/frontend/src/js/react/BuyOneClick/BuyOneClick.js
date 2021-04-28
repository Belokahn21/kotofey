import React from 'react';
import ReactDom from "react-dom";
import {Modal, Button} from 'react-bootstrap';
import RestRequest from "../../tools/RestRequest";
import config from '../../config';

class BuyOneClick extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            show: false
        };

        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id).then(data => {
            this.setState({product: data});
        });
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
        const {product_id} = this.props;
        console.log(this.state.product);
        return <>
            <a className="one-click-buy" onClick={this.handleShow.bind(this)}><span>В один клик</span></a>

            <Modal show={show} onHide={this.handleClose.bind(this)}>
                <Modal.Header closeButton>
                    <Modal.Title>
                        <div>Купить в 1 клик</div>
                        <div className="buy-one-click__product-title">Купить в 1 клик</div>
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>

                </Modal.Body>
            </Modal>
        </>
    }
}


let element = document.querySelector('.buy-one-click-react');
if (element) {

    let product_id = element.getAttribute('data-product-id');
    if (product_id) {
        ReactDom.render(<BuyOneClick product_id={product_id}/>, element);
    } else {
        ReactDom.render(<BuyOneClick/>, element);
    }
}
