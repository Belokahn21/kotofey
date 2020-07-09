import React from 'react';
import ReactDom from 'react-dom';
import config from '../../config';

class Statistic extends React.Component {
	constructor() {
		super();

		this.state = {
			items: []
		}

		fetch(config.restStatisticGet)
			.then(response => response.json())
			.then(json => {
				this.setState({
					items: JSON.parse(json),
				});
			});
	}

	render() {
		return (
			<ul className="statistic">
				{this.state.items.map((element, index) => {
					return <li className="statistic__item" key={index}>
						<div className="statistic__icon">
						<span>
							<i className={"fas " + element.icon}></i>
						</span>
						</div>
						<div className="statistic__content">
							<ul className="statistic-info">
								{element.data.map((element, index) => {
									return <li className="statistic-info__row" key={index}>
										<div className="statistic-info__key">{element.title}</div>
										<div className="statistic-info__value">{element.value}</div>
									</li>
								})}
							</ul>
						</div>
					</li>
				})}
			</ul>
		)
	}
}

const statistic = document.querySelector('.statistic-wrap');
if (statistic) {
	ReactDom.render(<Statistic/>, statistic);
}
