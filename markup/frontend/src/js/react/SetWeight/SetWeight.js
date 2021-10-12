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

        this.slider_params = JSON.parse(this.props.slider_params);
    }

    componentDidMount() {
        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id, '?expand=imageUrl').then(data => {
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
            min: 0,
            max: this.slider_params.max,
            from: 200,
            to: 500,
            grid: true
        });
    }

    render() {
        const {show, product} = this.state;
        console.log(product);

        return (
            <div>
                <div onClick={this.handleShow.bind(this)}>Купить на разновес</div>

                <Modal show={show} onHide={this.handleClose.bind(this)} onShow={this.handleOnShow.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Отмерить на разновес</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>

                        <div className="row">
                            <div className="col-sm-12">
                                <div className="set-weight-product">
                                    <img className="set-weight-product-image" src={product.imageUrl}/>
                                </div>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-sm-12">
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
    ReactDom.render(<SetWeight slider_params={element.getAttribute('data-slider-params')} product_id={element.getAttribute('data-product-id')}/>, element);
}