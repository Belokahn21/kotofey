import React from "react";
import ReactDom from "react-dom";
import {Modal} from "react-bootstrap";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import RepeatSuccess from "./RepeatSuccess";
import RepeatForm from "./RepeatForm";

class RepeatOrder extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            show: false,
            order: false,
            success: false,
            products: [],
        }
    }

    componentDidMount() {
        this.loadOrder();
    }

    loadOrder() {
        RestRequest.one(config.restOrder, this.props.id, '?expand=items').then(data => {
            this.setState({order: data});


            this.loadProducts();
        });
    }

    loadProducts() {
        let products = [];
        this.state.order.items.map(el => {
            RestRequest.one(config.restCatalog, el.product_id, '?expand=imageUrl').then(data => {
                products.push(data.items);
            });
        });


        this.setState({products: products});
    }

    setShow(show) {
        this.setState({show: show});
    }

    handleShow() {
        this.setShow(true);
    }

    handleClose() {
        this.setShow(false);
    }

    handleSubmitForm(event) {
        event.preventDefault();
        let data = new FormData();
        data.append('order_id', this.props.id);


        RestRequest.post(config.restOrderRepeat, {
            body: data
        }).then(data => {
            const status = parseInt(data.status);

            switch (status) {
                case 200:
                    // this.setShow(false);
                    this.setState({success: true});
                    break;
                case 500:
                    console.log(data.text);
                    break;
            }
        })
    }

    render() {

        const {show, products, success} = this.state;

        return (
            <>
                <button type="button" className="btn-main" onClick={this.handleShow.bind(this)}>Повторить заказ</button>
                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>
                            <div>Повторить заказ</div>
                        </Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        {success ? <RepeatSuccess handleShow={this.handleShow.bind(this)}/> : <RepeatForm products={products} handleSubmitForm={this.handleSubmitForm.bind(this)}/>}
                    </Modal.Body>
                </Modal>
            </>
        );
    }

}


const element = document.querySelector('.react-order-repeat');


if (element) {
    ReactDom.render(<RepeatOrder id={element.getAttribute('data-order-id')}/>, element);
}