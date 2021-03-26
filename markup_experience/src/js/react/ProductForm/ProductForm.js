import React from 'react';
import Price from "../../tools/Price";

class ProductForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            count: 1
        };

    }

    handlePlus(e) {
        let count = this.state.count;
        count = count + 1;
        this.setState({count: count});
    }

    handleMinus(e) {
        let count = this.state.count;
        count = count - 1;
        this.setState({count: count});
    }

    handleChange(e) {
        this.setState({count: e.target.value});
    }

    render() {
        const element = this.props.element, options = this.props.options;
        return <div itemProp="offers" itemScope="" itemType="http://schema.org/Offer">
            <form className="product-calc">
                <input type="hidden" readOnly="" name="product_id" value={element.id}/>
                <div className="product-calc__control-group">
                    <input type="hidden" name="count" className="product-calc__count" value={element.id}/>
                    <div className="div">

                        <button className="product-calc__control product-calc__minus" onClick={this.handleMinus.bind(this)} type="button">-</button>
                        <input name="count" type="text" className="product-calc__count js-product-calc-amount" onChange={this.handleChange.bind(this)} value={this.state.count} placeholder={this.state.count}/>
                        <button className="product-calc__control product-calc__plus" onClick={this.handlePlus.bind(this)} type="button">+</button>

                        {options.showPrice !== true ? null : <div className="product-calc__price-info">
                            <div className="product-calc__price-info-normal">Цена за товар: {Price.format(element.price)}₽</div>
                        </div>}
                    </div>
                </div>
            </form>
        </div>
    }
}

export default ProductForm;