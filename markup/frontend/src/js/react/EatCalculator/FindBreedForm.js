import React from "react";

class FindBreedForm extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="bread-filter">
                <div className="bread-filter-item">
                    <input className="bread-filter-item__input" onKeyUp={this.props.handleTyping} placeholder="Найти породу"/>
                </div>
            </div>
        );
    }
}

export default FindBreedForm;
