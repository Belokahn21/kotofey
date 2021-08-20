import React from "react";

class DeliveryService extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <div className="checkout-delivery-service">
            {this.props.models.map((el, key) => {
                return <div key={key} className="checkout-delivery-service__item">{el.name}</div>
            })}
        </div>;
    }
}

export default DeliveryService;