import React from "react";

class DeliveryService extends React.Component {
    constructor(props) {
        super(props);

        this.services = ['DPD', 'CDEK', 'Почта России'];
    }

    render() {
        return <div className="checkout-delivery-service">
            {this.services.map((el, key) => {
                return <div key={key} className="checkout-delivery-service__item">{el}</div>
            })}
        </div>;
    }
}

export default DeliveryService;