import React from 'react';
import ReactDom from 'react-dom';

class Statistic extends React.Component {
	render() {
		return (
			<ul className="statistic">
				<li className="statistic__item">
					<div className="statistic__icon">
						<i className="fas fa-clipboard"></i>
					</div>
					<div className="statistic__content">
						Что-то описать
					</div>
				</li>
			</ul>
		)
	}
}

ReactDom.render(<Statistic/>, document.querySelector('.statistic-wrap'));