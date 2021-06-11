import React from "react";
import ReactDom from "react-dom";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

class CompareList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            mixed_data: []
        }

        this.loadMixedData();
    }

    loadMixedData() {
        RestRequest.all(config.restCompareMixed).then(data => {
            this.setState({mixed_data: data});
        })
    }

    render() {
        const {mixed_data} = this.state;
        console.log(mixed_data);
        return (
            <>

            </>
        );
    }
}

let init = document.querySelectorAll('.compare-list-react');
if (init) init.forEach(el => {
    ReactDom.render(<CompareList/>, el);
})