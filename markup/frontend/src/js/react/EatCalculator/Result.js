import React from "react";

class Result extends React.Component {
    constructor(props) {
        super(props);

    }

    render() {
        const {models} = this.props;
        return (
            <div className="eat-calculator-result">
                {models.map((el, index) => {
                    return <div key={index} className="eat-calculator-result-item">
                        <div className="eat-calculator-result-item__image-wrap">
                            <a data-lightbox="roadtrip" href={el.imageUrl}><img alt={el.name} title={el.name} className="eat-calculator-result-item__image" src={el.imageUrl}/></a>
                        </div>

                        <div className="eat-calculator-result-item__name">
                            <a className="eat-calculator-result-item__link" href={el.href}>{el.name}</a>
                        </div>

                        <a href={el.href} className="eat-calculator-result-item__action">Купить</a>
                    </div>
                })}
            </div>
        );
    }

}

export default Result;