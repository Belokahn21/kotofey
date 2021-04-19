import {Component} from 'react';

class Media extends Component {

    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div>
                demo media cdn
            </div>
        );
    }
}

const element = document.querySelector('.js-cdn-react');
if (element) ReactDOM.render(<Media/>, element);