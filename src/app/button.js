import React from 'react';
import { NavLink } from 'react-router-dom';
import { PropTypes } from 'prop-types';

export default function Button(props) {
	let Tagname = 'button';
	let className = 'dib bg-animate pointer no-underline br-pill pv3 ph5 bn';

	if (props.href) {
		Tagname = 'a';
	}

	if (props.to) {
		Tagname = NavLink;
	}

	if (props.inverted) {
		className += ' bg-white hover-bg-near-white hover-secondary';
	} else {
		className += ' white bg-primary hover-bg-secondary';
	}

	return <Tagname {...{ className }} {...props} />;
}

Button.propTypes = {
	to: PropTypes.string,
	href: PropTypes.string,
	inverted: PropTypes.bool,
};
