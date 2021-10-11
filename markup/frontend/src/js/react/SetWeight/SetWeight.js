import ReactDom from "react-dom";
import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import {Modal} from 'react-bootstrap';

var slider = require('ion-rangeslider');

class SetWeight extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            product: {},
            show: false,
        }

        this.loadProduct();
    }

    componentDidMount() {

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

    handleOnShow() {
        $(".js-range-slider-set-weight").ionRangeSlider({
            type: "double",
            min: 0,
            max: 1000,
            from: 200,
            to: 500,
            grid: true
        });
    }

    render() {
        const {show} = this.state;
        return (
            <div>
                <div onClick={this.handleShow.bind(this)}>Купить на разновес</div>

                <Modal show={show} onHide={this.handleClose.bind(this)} onShow={this.handleOnShow.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Отмерить на разновес</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>

                        <div className="row">
                            <div className="col-sm-6">pack</div>
                            <div className="col-sm-6">
                                <input type="text" className="js-range-slider-set-weight" name="my_range" value=""/>
                            </div>
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