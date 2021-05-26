import React from "react";
import ReactDom from "react-dom";
import {Form, Modal} from "react-bootstrap";
import Button from "../FindProduct/Button";

class FindCustomerFormResult extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        const {items} = this.props;
        return (
            <div className="list-finds">
                {items.map((el, index) => {
                    return <div className="list-finds__item" key={index}>
                        <a href="#" className="list-finds__link">{el.name}</a>
                        <Button productId={el.id} inputId={this.inputId}/>
                    </div>
                })}
            </div>
        );
    }
}

export default FindCustomerFormResult;