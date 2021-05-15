import React from 'react';
import ReactDom from 'react-dom';
import AlreadyAdmission from "./AlreadyAdmission";
import NewAdmission from "./NewAdmission";
import ModalNotify from "../ModalNotify";

class ProductAdmission extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            isAlreadyAdmission: props.isAlreadyAdmission
        };
    }

    handleSubmitForm(event) {
        event.preventDefault();

        let form = event.target;
        const {url} = this.props;

        fetch(url, {
            method: 'POST',
            body: new FormData(form),
        }).then(response => response.json()).then(data => {
            let response = JSON.parse(data);
            console.log(response);

            if (response.success == 1) {
                this.setState({
                    isAlreadyAdmission: true
                })
            }
        });
    }

    handleRemove(event) {
        event.preventDefault();
        let form = event.target;
        fetch('/remove-notify-admission/', {
            method: 'POST',
            body: new FormData(form),
        }).then(response => response.json()).then(data => {
            let response = JSON.parse(data);
            console.log(response);

            if (response.success == 1) {
                this.setState({
                    isAlreadyAdmission: false
                })
            }
        });
    }

    render() {
        const {isAlreadyAdmission, product_id} = this.props;

        if (isAlreadyAdmission) return <AlreadyAdmission product_id={product_id} handleRemove={this.handleRemove.bind(this)}/>
        else return <NewAdmission product_id={product_id} handleSubmitForm={this.handleSubmitForm.bind(this)}/>;

    }
}

let elements = document.querySelectorAll('.product-admission-react');

if (elements) {
    elements.forEach(element => {
        ReactDom.render(<ProductAdmission isAlreadyAdmission={element.getAttribute('data-isAlreadyAdmission')} url={element.getAttribute('data-form-action')} product_id={element.getAttribute('data-product-id')}/>, element);
    });
}