import ReactDom from 'react-dom';
import React from 'react';

class InstagramMedia extends React.Component {
	constructor() {
		super();
		this.state = {
			items: []
		};

		fetch('http://local.kotofey.store/instagram/rest-backend/get/').then(response => response.json()).then((data) => {
			this.setState({
				items: JSON.parse(data),
			})
		});
	}

	render() {
		return <div className="swiper-container instagram-container">
			<div className="swiper-wrapper instagram-wrapper">
				{this.state.items.map((element, index) => {
					return <div className="instagram__slide swiper-slide" key={index}>
						<img className="instagram__image" src={element.src} alt={element.title} title={element.title} />
						<a className="instagram__title" href={element.href} target="_blank">{element.title}</a>
					</div>
				})}
			</div>
			<div className="instagram-pagination swiper-pagination"></div>
		</div>
	}
}


const InstagramMediaDom = document.querySelector('.instagram-media');
if (InstagramMediaDom) {
	ReactDom.render(<InstagramMedia/>, InstagramMediaDom);
}
