import React from 'react';
import ReactDom from "react-dom";
import FindProductForm from './FindProductForm';

class Index extends React.Component {
    constructor(props) {
        super(props);

        let options = JSON.parse(props.options);

        this.modalId = options.modal;
    }


    render() {
        return <div>
            <div className="modal fade" id={this.modalId} tabIndex="-1" role="dialog" aria-labelledby={this.modalId + 'Label'} aria-hidden="true">
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id={this.modalId + 'Label'}>Найти товар</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <FindProductForm/>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>;
    }
}


const findProduct = document.querySelectorAll('.find-product');

if (findProduct) {
    findProduct.forEach(el => {
        let options = findProduct.attribute('data-options');
        ReactDom.render(<Index options={options}/>, el);
    });
}