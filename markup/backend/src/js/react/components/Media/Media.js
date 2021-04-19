import React from 'react';
import ReactDOM from 'react-dom';
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from '../../config';

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

    render() {

        const {resources} = this.state;

        return (
            <div>
                {resources.map((el, i) => {
                    return <img width="200" src={el.secure_url}/>;
                })}
            </div>
        );
    }
}

const element = document.querySelector('.js-cdn-react');
if (element) ReactDOM.render(<Media/>, element);