import React from "react";

class ResultSearch extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        if (this.props.items.length > 0) {
            return <div className={this.props.items.length > 0 ? "list-variants filled" : "list-variants"}>
                {this.props.items.map((product, index) => {
                    return <div className="list-variants__item" key={index}>
                        <a href={product.href}>{product.name}</a>
                    </div>
                })}
            </div>
        } else {
            return ('');
        }
    }
}

module.exports = ResultSearch;