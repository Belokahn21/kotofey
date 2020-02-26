import React, {Component} from "react";

import '../styles/App.css';

class App extends Component {
    render() {
        return (
            <form className="milenium-form">
                <input type="text" value={this.props.result.name}/>
                <input type="text" value={this.props.result.price}/>
                <input type="text" value={this.props.result.article}/>
                <input type="text" value={this.props.result.weight}/>
            </form>
        );
    }
}

export default App;