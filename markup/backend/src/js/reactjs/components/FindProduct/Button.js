import React from "react";

class Button extends React.Component {
    constructor(props) {
        super(props);
    }

    handleSetup(e) {
        let input = document.querySelector('#uniq-' + this.props.inputId);
        if (!input) return false;
        input.value = this.props.productId;
        input.dispatchEvent(new Event('change'));
    }

    render() {
        return <button type="button" className="list-finds__setup" onClick={this.handleSetup.bind(this)}>Выбрать</button>
    }
}

export default Button;