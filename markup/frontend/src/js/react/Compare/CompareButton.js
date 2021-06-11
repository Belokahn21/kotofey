import React from "react";
import ReactDom from 'react-dom';

class CompareButton extends React.Component {
    constructor() {
        super();
        this.state = {
            is_added: false
        }
    }

    render() {
        const {is_added} = this.state;
        let html
        switch (is_added) {
            case true:
                html = "<div class='compare-button'>Сравнить товар</div>"
                break;
            case false:
                html = "<a href='/compare/' class='compare-button-next'>Перейти к сравнению</a>"
                break;
        }

        return html;
    }
}


let init = document.querySelectorAll('.compare-button-react');
if (init) init.forEach(el => {
    ReactDom.render(<CompareButton/>, el);
})