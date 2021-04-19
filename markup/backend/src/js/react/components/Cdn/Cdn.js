import React from 'react';
import ReactDOM from 'react-dom';

class Cdn extends React.Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                <button type="button" className="btn-main">Выбрать</button>
            </div>
        );
    }
}

const element = document.querySelector('.cdn-modal-react');
if (element) ReactDOM.render(<Cdn/>, element);