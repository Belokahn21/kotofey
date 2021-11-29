import React from "react";
import ReactDom from "react-dom";
import NewProduct from "./NewProduct";


function Ozon(props) {
    return <div>
        <NewProduct/>
    </div>
}


let element = document.querySelector('.ozon-react');
if (element) ReactDom.render(<Ozon/>, element);