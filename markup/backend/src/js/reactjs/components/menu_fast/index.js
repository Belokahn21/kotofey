import React from 'react';
import config from "../../config";

class MenuFast extends React.Component {
    constructor() {
        super();
        const url = config.restMenuFast;

        this.state = {
            items: []
        }

        fetch(url)
            .then(response => response.json())
            .then(json => {
                this.setState({
                    items: JSON.parse(json),
                });
            });
    }

    render() {
        if (this.state.items) {

            return (
                <ul className="fast-links">
                    {this.state.items.map((element, index) => {
                        let newPointStatus = "";
                        if (element.isNewData) newPointStatus = <div className="point">{element.isNewData}</div>;

                        return <li className="fast-links__item" key={index}>
                            {newPointStatus}
                            <a className="fast-links__link" href={element.href}>
                                <i className={"fas " + element.icon}></i>
                            </a>
                        </li>
                    })}
                </ul>
            )
        } else {
            return null;
        }
    }
}

module.exports = MenuFast;