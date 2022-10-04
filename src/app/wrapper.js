import React from 'react';

import { PropTypes } from 'prop-types';

export default function Wrapper({ children }) {
	return (
		<div
			id="page-content-wrapper"
			className="w-100 mw7 br3 pa4 mv3 center bg-white shadow-1"
		>
			{children}
		</div>
	);
}

Wrapper.propTypes = {
	children: PropTypes.node.isRequired,
};
