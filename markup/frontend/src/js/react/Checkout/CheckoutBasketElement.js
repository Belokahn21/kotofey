import React from 'react';
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import ProductForm from "../ProductForm/ProductForm";

class CheckoutBasketElement extends React.Component {
    constructor(props) {
        super(props);
    }

    delete(event) {
        const element = event.target;
        const product_id = element.getAttribute('data-product-id');

        if (!product_id) return false;

        RestRequest.delete(config.restBasket, product_id).then(data => {
            this.props.refreshBasket(product_id);
        });
    }

    render() {
        const element = this.props.element;

        let removeButton;

        if (element.id) {
            removeButton = <div className="clear-basket" onClick={this.delete.bind(this)} data-toggle="tooltip" rel="tooltip" data-product-id={element.id} data-placement="right" title="" data-original-title="Удалить товар из корзины">
                <i className="fas fa-trash-alt" aria-hidden="true"/>
            </div>;
        }

        return <li className="light-checkout-list__item" key={element.id}>
            {removeButton}
            <img alt={element.name} title={element.name} className="light-checkout-list__image" src={element.imageUrl}/>
            <div className="light-checkout-list__info">
                <div className="light-checkout-list__title">
                    <a className="light-checkout-list__link" href={element.detailUrl}>{element.name}</a>
                </div>
                {!element.article ? '' : <div className="light-checkout-list__article">Артикул: {element.article}</div>}
            </div>
            <ProductForm key={element.name} updateBasketItem={this.props.updateBasketItem} element={element} options={{
                'showButton': false,
                'showInfo': false,
                'showOneClick': false,
                'showPrice': true,
                'showControl': element.id !== undefined,
            }}/>
        </li>
    }
}

export default CheckoutBasketElement;