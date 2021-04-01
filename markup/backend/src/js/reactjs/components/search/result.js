import React from 'react';

class SearchResult extends React.Component {

	render() {
		if (this.props.isNeedShow) {
			return (
				<div className="search-result-wrap">
					<p className="search-result__label">Результаты:</p>
					<ul className="search-result">
						{this.props.result.map((product, index) => {
							return <li className="search-result__item" key={index}><a href="" className="search-result__link">{product.name}</a></li>
						})}
					</ul>
				</div>
			);
		} else {
			return ('');
		}
	}
}

export default SearchResult;