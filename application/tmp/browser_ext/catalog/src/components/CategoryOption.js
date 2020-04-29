import React, {Component} from "react";

import '../styles/CategoryOption.css';

class CategoryOption extends Component {
    render() {
        let items = [];
        let json = JSON.parse(this.props.result);
        {
            items.push(<option value="">Раздел</option>);
            for (var i in json[0]) {
                items.push(<option value={json[0][i].id}>{json[0][i].name}</option>);
            }
        }
        return items;
    }
}

export default CategoryOption;