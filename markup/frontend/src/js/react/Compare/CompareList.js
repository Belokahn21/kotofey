import React from "react";
import ReactDom from "react-dom";

class CompareList extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>

            </div>
        );
    }
}

let init = document.querySelectorAll('.compare-list-react');
if (init) init.forEach(el => {
    ReactDom.render(<CompareList/>, el);
})