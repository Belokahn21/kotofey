import React from 'react';
import config from '../../config';

class Menu extends React.Component {
	constructor() {
		super();
		const url = config.restMenuGet;

		this.state = {
			items: []
		}

		fetch(url)
			.then(response => response.json())
			.then(json => {
				this.setState({
					items: JSON.parse(json),
				});
			});
	}

	render() {
		if (this.state.items) {
			return (
				<ul className="menu">
					{this.state.items.map((item) => {
						return <li className="menu__item">
							<a className="menu__link" href={item.href}>
								<span>{item.title}</span><span className="menu__icon"><i className="fas fa-globe-americas"></i></span>
							</a>
						</li>
					})}
				</ul>
			);
		} else {
			return null;
		}
	}
}

module
	.exports = Menu;