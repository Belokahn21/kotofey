import React, {Component} from 'react';
import CheckoutBasketElement from "./CheckoutBasketElement";

class CheckoutBasket extends Component {
    constructor(props) {
        super(props);
    }


    render() {
        const deliveryItem = {name: 'Доставка', imageUrl: '/images/not-image.png'};
        let delivery;
        if (parseInt(this.props.total) < 500) delivery = <CheckoutBasketElement key="delivery" element={deliveryItem}/>

        return (
            <ul className="light-checkout-list">
                {delivery}
                {this.props.basket.map((element, key) => {
                    return <CheckoutBasketElement key={key} element={element} refreshBasket={this.props.refreshBasket}/>
                })}
            </ul>
        );
    }
}

export default CheckoutBasket;