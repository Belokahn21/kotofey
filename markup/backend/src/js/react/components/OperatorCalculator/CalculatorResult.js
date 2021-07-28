import React from 'react';
import Price from "../../../../../../frontend/src/js/tools/Price";

class CalculatorResult extends React.Component {

    constructor(props, context) {
        super(props, context);
    }

    render() {
        const {tariff_list} = this.props;
        return (
            <div className="calc-result">
                Варианты доставки
                <ul className="delivery-variants">
                    {tariff_list.map((el, i) => {
                        return <li className="delivery-variants-item" key={i}>
                            <div className="delivery-variants-item__header">
                                <div className="delivery-variants-item__name">
                                    Тариф: {(el.name === null) ? 'Без указания' : el.name}
                                </div>
                                <div className="delivery-variants-item__time">
                                    Время доставки: {el.max_days} дн.
                                </div>
                            </div>
                            <div className="delivery-variants-item__body">
                                <div className="delivery-variants-item__money">
                                    Стоимость доставки: {Price.format(el.total)} руб.
                                </div>
                            </div>
                        </li>
                    })}
                </ul>
            </div>
        );
    }
}

export default CalculatorResult;