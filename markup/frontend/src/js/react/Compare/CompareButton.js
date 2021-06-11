import React from "react";
import ReactDom from 'react-dom';
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

class CompareButton extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            is_added: this.props.already === '1'
        }
    }

    onClickEvent(event) {
        event.preventDefault();
        let data = new FormData();
        data.append('product_id', this.props.product_id);

        RestRequest.post(config.restCompare, {
            body: data
        }).then(data => {
            this.setState({is_added: data})
        });

    }

    render() {
        const {is_added} = this.state;
        let html
        switch (is_added) {
            case true:
                html = <a href='/compare/' className='compare-button compare-button-next'>Перейти к сравнению</a>
                break;
            case false:
                html = <div className='compare-button' onClick={this.onClickEvent.bind(this)}>Сравнить товар</div>
                break;
        }

        return html;
    }
}


let init = document.querySelectorAll('.compare-button-react');
if (init) init.forEach(el => {
    ReactDom.render(<CompareButton already={el.getAttribute('data-already')} product_id={el.getAttribute('data-id')}/>, el);
})