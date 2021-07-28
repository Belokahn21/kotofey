import React from "react";

class Location extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {items,selectAddress} = this.props;
        return <ul>


            <div className="list-finds">
                {items.map((el, index) => {
                    return <div key={index} className="list-finds__item">
                        <div>{el.index ? el.index : ''}{el.city ? ', ' + el.city : ''}{el.street ? ', ' + el.street : ''}{el.home ? ', ' + el.home : ''}{el.room ? ', кв ' + el.room : ''}</div>
                        <button className="list-finds__setup" onClick={selectAddress.bind(this, el)}>Выбрать</button>
                    </div>
                })}
            </div>
        </ul>
    }
}

export default Location;