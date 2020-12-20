import React from 'react';

import config from '../../config';

class FindProductForm extends React.Component {
    constructor() {
        super();

        this.state = {
            items: []
        };
    }

    handleInput(e) {
        fetch(config.restCatalogGet).then(result => result.json()).then(data => {
            console.log(data);
        });
    }

    render() {
        return <form>
            <input onKeyUp={this.handleInput.bind(this)}/>

            {this.state.items.map((el, index) => {
                console.log(el);
            })}
        </form>;
    }
}

module.exports = FindProductForm;