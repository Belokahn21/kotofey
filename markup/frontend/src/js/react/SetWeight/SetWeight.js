import ReactDom from "react-dom";
import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

class SetWeight extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            product: {},
            show: false,
        }

        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id).then(data => {
            this.setState({product: data});
        });
    }

    handleClose() {
        this.setShow(false);
    }

    handleShow() {
        this.setShow(true);
    }

    setShow(show) {
        this.setState({show: show});
    }

    render() {
        const {show} = this.state;
        return (
            <div>
                <div className="form-finds__setup" onClick={this.handleShow.bind(this)}>+</div>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Отмерить на разновес</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>

                        <div className="row">
                            <div className="col-sm-6">pack</div>
                            <div className="col-sm-6">progress</div>
                        </div>

                    </Modal.Body>
                </Modal>
            </div>
        );
    }

}


const element = document.querySelector('.set-weight-react');
if (element) {
    ReactDom.render(<SetWeight product_id={element.getAttribute('data-product-id')}/>, element);
}