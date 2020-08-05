import React from 'react';
import ReactDom from 'react-dom';
import config from '../../config';
import Item from './item';

class Statistic extends React.Component {
    constructor() {
        super();

        this.state = {
            items: []
        }

        fetch(config.restStatisticGet)
            .then(response => response.json())
            .then(json => {
                this.setState({
                    items: JSON.parse(json),
                });
            });
    }

    render() {
        return (
            <ul className="statistic">
                {this.state.items.map((element, index) => {
                    return <Item element={element} index={index}/>
                })}
            </ul>
        )
    }
}

const statistic = document.querySelector('.statistic-wrap');
if (statistic) {
    ReactDom.render(<Statistic/>, statistic);
}
