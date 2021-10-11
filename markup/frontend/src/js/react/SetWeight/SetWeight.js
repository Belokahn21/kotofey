import ReactDom from "react-dom";
import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

class SetWeight extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            product: {}
        }

        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id).then(data => {
            this.setState({product: data});
        });
    }

    render() {
        return (
            <div>

            </div>
        );
    }

}


const element = document.querySelector('.set-weight-react');
if (element) {
    ReactDom.render(<SetWeight product_id={element.getAttribute('data-product-id')}/>, element);
}