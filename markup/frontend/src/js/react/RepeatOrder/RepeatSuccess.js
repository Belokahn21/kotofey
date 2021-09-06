import React from "react";

class RepeatSuccess extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {handleShow} = this.props;
        return <div className="order-repeat-success">
            <div className="order-repeat-success__status">
                <img src="/images/tick.png"/>
            </div>
            <div className="order-repeat-success__thanks">
                Спасибо за покупку!
            </div>
            <div className="order-repeat-notes">
                Ваш заказ успешно создан и отправлен в работу! В течении 60 минут наши менеджеры свяжутся с вами для согласования деталей заказа!
            </div>
            <div className="order-repeat-success__close">
                <button type="button" className="btn-main" onClick={handleShow.bind(this)}>Закрыть</button>
            </div>
        </div>
    }

}

export default RepeatSuccess;