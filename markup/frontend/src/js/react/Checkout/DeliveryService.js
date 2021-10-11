import React from "react";

class DeliveryService extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <div className="checkout-delivery-service">
            {this.props.models.map((el, key) => {
                return <label key={key} className="checkout-delivery-service-item">
                    <input onChange={this.props.handleSelectDeliveryService} type="radio" className="checkout-delivery-service-item__input" name="service" value={el.code}/>
                    <div className="checkout-delivery-service-item__mark"><i className="far fa-check-circle"/></div>
                    <img alt={el.name} title={el.name} className="checkout-delivery-service-item__icon" src={el.imageUrl}/>
                    <div className="checkout-delivery-service-item__name">{el.name}</div>
                </label>
            })}
        </div>;
    }
}

export default DeliveryService;