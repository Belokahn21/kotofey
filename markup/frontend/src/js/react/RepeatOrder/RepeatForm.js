import React from "react";
import Price from "../../tools/Price";

class RepeatForm extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        const {products, handleSubmitForm} = this.props;
        return <>
            <div className="order-repeat-products">
                {products.map((el, key) => {
                    return <div key={key} className="order-repeat-products-item">
                        <div className="order-repeat-products-item__image">
                            <img src={el.imageUrl} alt={el.name} title={el.name}/>
                        </div>
                        <div className="order-repeat-products-item__name">
                            {el.name}
                        </div>
                        <div className="order-repeat-products-item__price">
                            {Price.format(el.price)} ₽
                        </div>
                    </div>;
                })}
            </div>

            <hr/>

            <div className="order-repeat-notes">
                В новый заказ возьмутся данные: E-mail, телефон, адрес доставки из текущего заказа.
            </div>

            <hr/>

            <button className="btn-main" type="button" onClick={handleSubmitForm.bind(this)}>Повторить заказ</button>
        </>
    }
}

export default RepeatForm;