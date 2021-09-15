import React from "react";

class RepeatForm extends React.Component {

    constructor(props) {
        super(props);

    }


    render() {
        const {order} = this.props;
        return (
            <div>
                <input type="text" placeholder="email" defaultValue={order.email}/>
                <input type="text" placeholder="phone" defaultValue={order.phone}/>
                <input type="text" placeholder="status_id" defaultValue={order.status_id}/>
            </div>
        );
    }

}

export default RepeatForm;