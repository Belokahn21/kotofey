import React from 'react';

import config from '../../config';

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

    handleSetup(e) {
        let input = document.querySelector('#uniq-' + this.inputId);
        let button = e.target;

        console.log(input);
        console.log(this.inputId);

        if (!input) return false;

        input.value = button.getAttribute('data-product-id');
    }


    render() {
        return <form>
            <input onKeyUp={this.handleInput.bind(this)}/>

            <div className="list-finds">
                {this.state.items.map((el, index) => {
                    return <div className="list-finds__item" key={index}>
                        <a href="#" className="list-finds__link">{el.name}</a>
                        <button type="button" className="list-finds__setup" onClick={this.handleSetup.bind(this)} data-product-id={el.id}>Выбрать</button>
                    </div>
                })}
            </div>
        </form>;
    }
}

module.exports = FindProductForm;