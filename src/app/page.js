import React from 'react';

import { PropTypes } from 'prop-types';

import Title from '../app/title';
import Wrapper from '../app/wrapper';

export default function Page({ children, title }) {
	return (
		<Wrapper>
			<Title>{title}</Title>

			<div className="w-100 mw8 ph3 center">
				<div className="entry-content">{children}</div>
			</div>
		</Wrapper>
	);
}

Page.propTypes = {
	children: PropTypes.node.isRequired,
	title: PropTypes.node.isRequired,
};
