import React from 'react';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";

class CalculatorProducts extends React.Component {
    constructor() {
        super();

        this.state = {
            products: []
        }
    }

    onChange(event) {
        event.preventDefault();
        let element = event.target;
        let value = element.value;

        RestRequest.all(config.restCatalog + '?ProductSearchForm[mixed_value]=' + value).then(data => {
            this.setState({products: data});
        })
    }

    render() {
        const {products} = this.state;
        return (
            <div className="calc-products">
                <div className="calc-products-search">

                    <label className="calc-products-search__label">
                        <input className="calc-products-search__input" placeholder="Фильтр товаров (название, артикул, внешний код)" type="text" onChange={this.onChange.bind(this)}/>
                    </label>

                </div>

                <div className="calc-products-result">
                    {products.map((product, index) => {
                        return <label key={index} className="calc-products-result__label">
                            <input type="checkbox" name="products[]" value={product.id} className="calc-products-result__input"/>
                            <div className="calc-products-result__item">
                                <div className="calc-products-result__name">
                                    {product.name}
                                </div>
                                <div className="calc-products-result__checked">
                                    <i className="fas fa-check"/>
                                </div>
                            </div>
                        </label>
                    })}
                </div>
            </div>
        );
    }
}

export default CalculatorProducts;