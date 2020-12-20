import React from 'react';
import ReactDom from "react-dom";
import FindProductForm from './FindProductForm';

class Index extends React.Component {
    constructor() {
        super();
    }


    render() {
        return <div>
            <div className="modal fade" id="' . $modalId . '" tabIndex="-1" role="dialog" aria-labelledby="' . $modalId . 'Label" aria-hidden="true">
                <div className="modal-dialog" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="' . $modalId . 'Label">Найти товар</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <FindProductForm/>
                        </div>
                        <div className="modal-footer">
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" className="btn btn-primary">Save changes</button>
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
        ReactDom.render(<Index/>, el);
    });
}