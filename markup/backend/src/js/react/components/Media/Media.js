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

    handleRemove() {
        console.log('demo remove');
        alert();
    }

    render() {

        const {resources} = this.state;

        return (
            <div>
                {resources.map((el, i) => {
                    return <MediaCard handleRemove={this.handleRemove} resource={el}/>
                })}
            </div>
        );
    }
}

const element = document.querySelector('.js-cdn-react');
if (element) ReactDOM.render(<Media/>, element);