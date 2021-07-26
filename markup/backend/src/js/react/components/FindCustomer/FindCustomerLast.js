import React from 'react';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../config";

class FindCustomerLast extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            items: []
        };

        this.load();
    }

    load() {
        RestRequest.all(config.restOrderCustomer + '?expand=cross&sort=-created_at&limit=5').then(data => {
            this.setState({items: data})
        });
    }

    render() {
        const {items} = this.state;
        return <div>
            <br/>
            <h5>Последние карточки</h5>
            <div className="list-finds">
                {items.map((customer, index) => {
                    return <div key={index} className="list-finds__item">
                        <div>{customer.phone} / {customer.name}</div>
                        <button className="list-finds__setup" onClick={this.props.handleSelectCustomer.bind(this, customer)}>Выбрать</button>
                    </div>
                })}
            </div>
        </div>
    }
}

export default FindCustomerLast;