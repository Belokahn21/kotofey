import React from 'react';
import ReactDom from 'react-dom';

class Statistic extends React.Component {
    render() {
        return (
            <ul className="statistic">
                <li className="statistic__item">
                    <div className="statistic__icon">
						<span>
							<i className="fas fa-clipboard"></i>
						</span>
                    </div>
                    <div className="statistic__content">
                        <ul className="statistic-info">
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Заказов</div>
                                <div className="statistic-info__value">120</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Выручка</div>
                                <div className="statistic-info__value">40 000р</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Оборот</div>
                                <div className="statistic-info__value">140 000р</div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li className="statistic__item">
                    <div className="statistic__icon">
						<span>
							<i className="fas fa-clipboard"></i>
						</span>
                    </div>
                    <div className="statistic__content">
                        <ul className="statistic-info">
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Заказов</div>
                                <div className="statistic-info__value">120</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Выручка</div>
                                <div className="statistic-info__value">40 000р</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Оборот</div>
                                <div className="statistic-info__value">140 000р</div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li className="statistic__item">
                    <div className="statistic__icon">
						<span>
							<i className="fas fa-clipboard"></i>
						</span>
                    </div>
                    <div className="statistic__content">
                        <ul className="statistic-info">
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Заказов</div>
                                <div className="statistic-info__value">120</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Выручка</div>
                                <div className="statistic-info__value">40 000р</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Оборот</div>
                                <div className="statistic-info__value">140 000р</div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li className="statistic__item">
                    <div className="statistic__icon">
						<span>
							<i className="fas fa-clipboard"></i>
						</span>
                    </div>
                    <div className="statistic__content">
                        <ul className="statistic-info">
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Заказов</div>
                                <div className="statistic-info__value">120</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Выручка</div>
                                <div className="statistic-info__value">40 000р</div>
                            </li>
                            <li className="statistic-info__row">
                                <div className="statistic-info__key">Оборот</div>
                                <div className="statistic-info__value">140 000р</div>
                            </li>
                        </ul>
                    </div>
                </li>
				<li className="statistic__item">
					<div className="statistic__icon">
						<span>
							<i className="fas fa-clipboard"></i>
						</span>
					</div>
					<div className="statistic__content">
						<ul className="statistic-info">
							<li className="statistic-info__row">
								<div className="statistic-info__key">Заказов</div>
								<div className="statistic-info__value">120</div>
							</li>
							<li className="statistic-info__row">
								<div className="statistic-info__key">Выручка</div>
								<div className="statistic-info__value">40 000р</div>
							</li>
							<li className="statistic-info__row">
								<div className="statistic-info__key">Оборот</div>
								<div className="statistic-info__value">140 000р</div>
							</li>
						</ul>
					</div>
				</li>
            </ul>
        )
    }
}

ReactDom.render(<Statistic/>, document.querySelector('.statistic-wrap'));