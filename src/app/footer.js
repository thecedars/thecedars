import React from 'react';

export default function Footer() {
	return (
		<footer id="footer" className="tc">
			<div className="pv2 f7">
				Copyright {DATE} The Cedars <span> | All rights reserved</span>
			</div>
		</footer>
	);
}

const DATE = new Date().getFullYear();
