import ReactDom from "react-dom";
import React from "react";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";
import Price from "../../tools/Price";
import Currency from "../../tools/Currency";
import {Modal} from 'react-bootstrap';
import BuyOneClick from "../BuyOneClick/BuyOneClick";

var slider = require('ion-rangeslider');

export default class SetWeight extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            product: {},
            show: false,
            count: 0,
        }
    }

    componentDidMount() {
        this.loadProduct();
    }

    loadProduct() {
        RestRequest.one(config.restCatalog, this.props.product_id, '?expand=imageUrl,weight').then(data => {
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
        const {product} = this.state;
        let _this = this;

        $(".js-range-slider-set-weight").ionRangeSlider({
            min: 0,
            step: product.weight / 100,
            max: product.weight,
            from: 0,
            grid: true,
            onChange: function (data) {
                _this.setState({count: data.from});
            },
        });
    }

    render() {
        const {show, product, count} = this.state;
        let rate = Math.round(product.price / product.weight), result = Math.round(rate * count);

        return (
            <div>
                <div className="set-weight-buy" onClick={this.handleShow.bind(this)}>Купить на разновес</div>

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

                        <div className="set-weight-rate">
                            <div className="set-weight-rate-item value">{count}{count > 1 ? 'кг' : 'гр'}</div>

                            <div className="set-weight-rate-item">x</div>

                            <div className="set-weight-rate-item value">
                                <div className="set-weight-rate-item__value">{Price.format(rate)}{Currency.show()}</div>
                                <div className="set-weight-rate-item__label">за кг</div>
                            </div>
                            <div className="set-weight-rate-item">=</div>

                            <div className="set-weight-rate-item value">
                                <div className="set-weight-rate-item__value">{Price.format(result)}{Currency.show()}</div>
                                <div className="set-weight-rate-item__label">Итого</div>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-sm-12">
                                <input type="text" className="js-range-slider-set-weight" name="my_range" value=""/>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-sm-6">
                                <BuyOneClick/>
                            </div>
                            <div className="col-sm-6">
                                <button className="btn-main">Добавить в корзину</button>
                            </div>
                        </div>

                    </Modal.Body>
                </Modal>
            </div>
        );
    }

}