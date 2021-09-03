import React from "react";
import ReactDom from "react-dom";
import {Modal} from "react-bootstrap";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import Price from "../../tools/Price";

class RepeatOrder extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            show: false,
            order: false,
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
                products.push(data);
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
                    this.setShow(false);
                    break;
                case 500:
                    console.log(data.text);
                    break;
            }
        })
    }

    render() {

        const {show, products} = this.state;

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

                        <div className="order-repeat-products">
                            {products.map((el, key) => {
                                return <div key={key} className="order-repeat-products-item">
                                    <div className="order-repeat-products-item__image">
                                        <img src={el.imageUrl} alt={el.name} title={el.name}/>
                                    </div>
                                    <div className="order-repeat-products-item__name">
                                        {el.name}
                                    </div>
                                    <div className="order-repeat-products-item__price">
                                        {Price.format(el.price)} ₽
                                    </div>
                                </div>;
                            })}
                        </div>

                        <hr/>

                        <button className="btn-main" type="button" onClick={this.handleSubmitForm.bind(this)}>Повторить заказ</button>

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