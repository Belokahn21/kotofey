import React from 'react';
import ReactDOM from 'react-dom';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from '../../config';
import MediaCard from "./MediaCard";

class Media extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            resources: []
        };

        this.loadResources();
    }

    loadResources() {
        RestRequest.all(config.restCdn).then(data => {
            this.setState({
                resources: data.resources
            })
        });
    }

    handleRemove(element, event) {
        const response = confirm('Удалить' + element.asset_id + ' ?');
        if (response) RestRequest.delete(config.restCdn, element.asset_id).then(data => {
            if (data) alert(element.asset_id + ' успешно удален.')
        });
    }

    render() {

        const {resources} = this.state;

        return (
            <div className="cdn-resource-list">
                {resources.map((el, i) => {
                    return <MediaCard handleRemove={this.handleRemove} resource={el}/>
                })}
            </div>
        );
    }
}

const element = document.querySelector('.js-cdn-react');
if (element) ReactDOM.render(<Media/>, element);