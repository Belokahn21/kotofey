import React from "react";
import {Modal} from "react-bootstrap";
import Location from "./Location";
import RestRequest from "../../../../../../frontend/src/js/tools/RestRequest";
import config from "../../../../../../frontend/src/js/config";

class FormLocation extends React.Component {
    constructor(props) {
        super(props);

        this.cleanAddressTimerEx;

        this.state = {
            show: false,
            postal: props.options.default,
            items: [],
        }
    }

    setShow(show) {
        this.setState({show: show});
    }

    handleClose() {
        this.setShow(false);
    }

    handleShow() {
        this.setShow(true);
    }

    handleClick(event) {
        event.preventDefault();
        let form = event.target.parentNode.parentNode;
        let input = form.querySelector("input[name='address']");

        if (input.value.length === 0) return false;

        if (this.cleanAddressTimerEx) clearTimeout(this.cleanAddressTimerEx);


        this.cleanAddressTimerEx = setTimeout(() => {
            RestRequest.all(config.restDeliveryCleanAddress + '?filter[text]=' + input.value).then(result => {
                let data = [];

                result.map(el => {
                    data.push({
                        index: el.index,
                        city: el.place,
                        street: el.street,
                        home: el.house,
                        room: el.room,
                    });
                });

                this.setState({items: data});
            });
        }, this.cleanAddressTimer);
    }

    selectAddress(address, event) {
        this.setState({postal: address.index});
    }

    render() {
        const {show, items, postal} = this.state;
        const {options} = this.props;

        return <div className="calc-placement__location">
            <Modal show={show} onHide={this.handleClose.bind(this)}>
                <Modal.Header closeButton>
                    <Modal.Title>Заполнить {options.placeholder}</Modal.Title>
                </Modal.Header>
                <Modal.Body>

                    <form className="choose-address">
                        <label className="choose-address__item"><input className="choose-address__input" type="text" placeholder="656992, г Барнаул, ул Попова, д 125, кв 18" name="address"/></label>
                        <button type="button" onClick={this.handleClick.bind(this)} className="btn-main">Найти адреса</button>
                    </form>

                    <Location selectAddress={this.selectAddress.bind(this)} items={items}/>

                </Modal.Body>
            </Modal>


            <button type="button" className="calc-placement__choose" onClick={this.handleShow.bind(this)}>+</button>
            <input type="text" defaultValue={postal} className="calc-placement__postal-code" readOnly={options.readonly} name={options.name} placeholder={options.placeholder}/>
        </div>
    }
}

export default FormLocation;