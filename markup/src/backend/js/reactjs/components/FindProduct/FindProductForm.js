import React from 'react';

import config from '../../config';
import Button from './Button';

class FindProductForm extends React.Component {
    constructor(props) {
        super(props);

        this.timerEx = null;
        this.timeTimer = 400;
        this.inputId = props.inputId;

        this.state = {
            items: []
        };
    }

    handleInput(e) {
        if (this.timerEx) clearTimeout(this.timerEx);
        let element = e.target;

        this.timerEx = setTimeout(() => {
            fetch(config.restCatalogGet + '?name=' + element.value).then(result => result.json()).then(result => {
                this.setState({
                    items: JSON.parse(result)
                });
            });
        }, this.timeTimer);
    }

    render() {
        return <form>
            <input onKeyUp={this.handleInput.bind(this)}/>

            <div className="list-finds">
                {this.state.items.map((el, index) => {
                    return <div className="list-finds__item" key={index}>
                        <a href="#" className="list-finds__link">{el.name}</a>
                        <Button productId={el.id} inputId={this.inputId} />
                    </div>
                })}
            </div>
        </form>;
    }
}

module.exports = FindProductForm;