import React from "react";

class Button extends React.Component {
    constructor(props) {
        super(props);

        this.productId = props.productId;
        this.inputId = props.inputId;
    }

    handleSetup(e) {
        let input = document.querySelector('#uniq-' + this.inputId);
        if (!input) return false;
        input.value = this.productId;
        input.dispatchEvent(new Event('change'));
    }

    render() {
        return <button type="button" className="list-finds__setup" onClick={this.handleSetup.bind(this)}>Выбрать</button>
    }
}

module.exports = Button;