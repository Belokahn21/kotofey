import React from "react";
import {Collapse} from "react-bootstrap";

class RepeatOrderItems extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            open: false
        };
    }

    setOpen(open) {
        this.setState({open: open});
    }

    render() {
        const {open} = this.state;
        const {items} = this.props;


        return (
            <>
                <a onClick={this.setOpen.bind(this, !open)} href="#">Товары в заказе</a>

                <Collapse in={open}>

                    <ul>
                        {items.map((el, index) => {
                            return <li key={index}>{el.name}</li>;
                        })}
                    </ul>

                </Collapse>
            </>
        );
    }

}

export default RepeatOrderItems;