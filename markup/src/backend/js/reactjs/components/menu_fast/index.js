import React from 'react';

class MenuFast extends React.Component {
	render() {
		return (
			<ul className="fast-links">
				<li className="fast-links__item">
					<div className="point"></div>
					<a className="fast-links__link" href="/"><i className="fas fa-receipt"></i></a>
				</li>
				<li className="fast-links__item">
					<a className="fast-links__link" href="/"><i className="fas fa-cubes"></i></a>
				</li>
			</ul>
		)
	}
}

module.exports = MenuFast;