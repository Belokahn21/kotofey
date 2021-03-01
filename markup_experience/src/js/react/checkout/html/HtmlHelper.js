import React, {Component} from "react";
import Input from "./Input";

class HtmlHelper extends Component {
    constructor(props) {
        super(props);

    }

    renderInput() {
        return <Input name={this.props.name} title={this.props.title} placeholder={this.props.placeholder}/>;
    }

    render() {

        switch (this.props.element) {
            case "input":
                this.renderInput();
                break;
        }

    }

}

export default HtmlHelper;