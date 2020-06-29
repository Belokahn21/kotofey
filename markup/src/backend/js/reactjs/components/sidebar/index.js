import React from 'react';
import ReactDom from 'react-dom';

class Sidebar extends React.Component {
    render() {
        return (
            <div>Разгоночный</div>
        )
    }
}
ReactDom.render(<Sidebar/>, document.querySelector('.left-side-react'));