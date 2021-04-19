import React from 'react';
import ReactDom from "react-dom";
import {Modal, Button} from 'react-bootstrap';
import FindProductForm from './FindProductForm';

class Index extends React.Component {
    constructor(props) {
        super(props);

        let options = JSON.parse(props.options);
        this.state = {
            show: false
        };
        this.modalId = options.modalId;
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

    render() {
        const {show} = this.state;
        return (
            <>
                <div className="form-finds__setup" onClick={this.handleShow.bind(this)}>+</div>

                <Modal show={show} onHide={this.handleClose.bind(this)}>
                    <Modal.Header closeButton>
                        <Modal.Title>Найти ID товара</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <FindProductForm inputId={this.modalId}/>
                    </Modal.Body>
                </Modal>
            </>
        );
    }


    // render() {
    //     return <div>
    //         <div className="modal fade" id={this.modalId} tabIndex="-1" role="dialog" aria-labelledby={this.modalId + 'Label'} aria-hidden="true">
    //             <div className="modal-dialog" role="document">
    //                 <div className="modal-content">
    //                     <div className="modal-header">
    //                         <h5 className="modal-title" id={this.modalId + 'Label'}>Найти товар</h5>
    //                         <button type="button" className="close" data-dismiss="modal" aria-label="Close">
    //                             <span aria-hidden="true">&times;</span>
    //                         </button>
    //                     </div>
    //                     <div className="modal-body">

    //                     </div>
    //                     <div className="modal-footer">
    //                         <button type="button" className="btn btn-secondary" data-dismiss="modal">Закрыть</button>
    //                     </div>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>;
    // }
}


const findProduct = document.querySelectorAll('.find-product-react');

if (findProduct) {
    findProduct.forEach(el => {
        let options = el.getAttribute('data-options');
        ReactDom.render(<Index options={options}/>, el);
    });
}