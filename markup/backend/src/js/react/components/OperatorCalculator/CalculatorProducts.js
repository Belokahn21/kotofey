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

        RestRequest.all(config.restCatalog + '?expand=imageUrl,backendHref,weight,width,height,length&ProductSearchForm[mixed_value]=' + value).then(data => {
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
                        return <>
                            <label key={index} className="calc-products-result__label">
                                <input type="checkbox" name={`[products][${product.id}]id`} value={product.id} className="calc-products-result__input"/>

                                <div className="calc-products-result__item">
                                    <div className="calc-products-result__image">
                                        <img src={product.imageUrl}/>
                                    </div>
                                    <div className="calc-products-result__name">
                                        <a href={product.backendHref} target="_blank">{product.name}</a>
                                    </div>
                                    <div className="calc-products-result-data">
                                        <div className="calc-products-result-data__row">
                                            <div className="calc-products-result-data__key">Вес</div>
                                            <div className="calc-products-result-data__value">{product.weight}</div>
                                        </div>
                                        <div className="calc-products-result-data__row">
                                            <div className="calc-products-result-data__key">ШхВхД</div>
                                            <div className="calc-products-result-data__value">{product.width}/{product.height}/{product.length}</div>
                                        </div>
                                    </div>
                                    <div className="calc-products-result__checked">
                                        <i className="fas fa-check"/>
                                    </div>
                                </div>
                            </label>

                            <input type="hidden" name={`dimension[${product.id}][weight]`} value={product.weight} className="calc-products-result__input"/>
                            <input type="hidden" name={`dimension[${product.id}][width]`} value={product.width} className="calc-products-result__input"/>
                            <input type="hidden" name={`dimension[${product.id}][length]`} value={product.length} className="calc-products-result__input"/>
                            <input type="hidden" name={`dimension[${product.id}][height]`} value={product.height} className="calc-products-result__input"/>
                        </>
                    })}
                </div>
            </div>
        );
    }
}

export default CalculatorProducts;