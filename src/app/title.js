import React from 'react';

import { PropTypes } from 'prop-types';

export default function Title({ children }) {
	return (
		<div className="title mb4">
			<div className="w-100 mw8 ph3 center">
				<h1 className="ma0 lh-solid">
					<span className="f3 fw4 db">{children}</span>
				</h1>
			</div>
		</div>
	);
}

Title.propTypes = {
	children: PropTypes.node.isRequired,
};
