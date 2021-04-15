import React, {Component} from 'react';
import PromotionElement from "./PromotionElement";
import ReactDom from "react-dom";

class Promotion extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <div>
            {[...Array(10)].map((e, i) => {
                <PromotionElement/>
            })}
        </div>;
    }
}

const element = document.querySelector('.promotion-form-react');
if (element) {
    ReactDom.render(<Promotion/>, element);
}


export default Promotion;