import React from 'react';

class FormAdmission extends React.Component {
    constructor() {
        super();
    }

    render() {
        const {handleSubmitForm, product_id} = this.props;
        return <form onSubmit={handleSubmitForm} className="form-admission">
            <label className="form-admission__label">
                <input type="text" name="NotifyAdmission[email]" placeholder="Электронный адрес" className="form-admission__input site-form__input"/>
            </label>

            <div className="form-admission__logic">И</div>

            <label className="form-admission__label">
                <input type="text" name="NotifyAdmission[phone]" className="form-admission__input site-form__input js-mask-ru" placeholder="Номер телефона"/>
            </label>

            <input type="hidden" name="NotifyAdmission[product_id]" value={product_id}/>

            <button className="form-admission__button btn-main" type="submit">Отправить</button>
        </form>
    }
}

export default FormAdmission;