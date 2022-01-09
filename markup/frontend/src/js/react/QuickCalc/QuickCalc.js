import React, {useEffect, useState} from "react";
import ReactDom from "react-dom";
import RestRequest from "../../tools/RestRequest";
import config from "../../config";

function QuickCalc({from, to, product_id}) {

    const [tarrifs, setTarriffs] = useState([]);

    useEffect(() => {
        let params = new FormData();
        params.append('from', from);
        params.append('to', to);
        params.append('product_id', product_id);

        RestRequest.post(config.restTariffs, {
            body: params
        }).then((data) => {
            setTarriffs(data);
        });
    }, []);

    return <div>
        {tarrifs.map((el, index) => {
            return <div key={index}>
                <div>Отправка с помощью {el.name}</div>
                <div>Стоимость доставки {el.total_sum}</div>
                <div>Доставка {el.min_day}-{el.max_day} дней</div>
            </div>
        })}
    </div>
}


let element = document.querySelector('.quick-calc-rest');
if (element) ReactDom.render(<QuickCalc from={element.getAttribute('data-from')} to={element.getAttribute('data-to')} product_id={element.getAttribute('data-product-id')}/>, element);