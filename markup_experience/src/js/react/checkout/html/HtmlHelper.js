import React, {Component} from "react";
import Input from "./Input";

class HtmlHelper extends Component {
    constructor(props) {
        super(props);

    }

    renderInput() {
        return <Input modelName={this.props.modelName} options={this.props.options}/>;
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