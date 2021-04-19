import React from 'react';
import ReactDom from "react-dom";
import PromotionElement from "./PromotionElement";

class Promotion extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <div>
            {[...Array(10)].map((e, i) => {
                return <PromotionElement/>
            })}
        </div>;
    }
}

const element = document.querySelector('.promotion-form-react');
if (element) {
    ReactDom.render(<Promotion/>, element);
}