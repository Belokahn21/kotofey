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
            <div className="repeat-order-products-container">
                <a onClick={this.setOpen.bind(this, !open)} href="#">Товары в заказе</a>

                <Collapse in={open}>

                    <ul className="repeat-order-products">
                        {items.map((el, index) => {
                            return <li className="repeat-order-products-item" key={index}>
                                <div>
                                    {el.count}шт Х {el.price}р.
                                </div>
                                <a href={`/admin/catalog/product-backend/update/?id=${el.product_id}`}>{el.name}</a>
                            </li>;
                        })}
                    </ul>

                </Collapse>
            </div>
        );
    }

}

export default RepeatOrderItems;