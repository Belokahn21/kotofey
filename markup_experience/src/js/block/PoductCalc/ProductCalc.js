import * as ProductCalcForm from './ProductCalcForm';

class ProductCalc {
    constructor(miniCart) {
        document.querySelectorAll('.js-product-calc').forEach(form => new ProductCalcForm(form, miniCart));
    }
}

export default ProductCalc;