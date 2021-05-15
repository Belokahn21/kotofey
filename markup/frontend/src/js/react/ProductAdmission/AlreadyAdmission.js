import React from 'react';

class AlreadyAdmission extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {handleRemove, product_id} = this.props;

        return <div className="product-status__already">
            <div>Вы уже отслеживаете этот товар</div>
            <form onSubmit={handleRemove} className="remove-notify-admission">
                <input type="hidden" name="product_id" value={product_id}/>
                <button type="submit" className="btn-main">Отмена</button>
            </form>
        </div>;
    }

}

export default AlreadyAdmission;