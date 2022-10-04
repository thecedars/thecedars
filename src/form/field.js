import React from 'react';

import { PropTypes } from 'prop-types';
import { useFormContext } from 'react-hook-form';

export default function Field({ field }) {
	const input = 'db w-100 f5 ba pa2 border-box bg-transparent b--moon-gray';

	const {
		id,
		label,
		weight,
		kind,
		pattern,
		patternmod,
		errormsg,
		required,
		options: selectOptions,
	} = field;

	const {
		register,
		formState: { errors },
	} = useFormContext();

	let width = 100;

	if (weight) {
		width = 100 / parseInt(weight);
	}

	const options = {};

	if (pattern) {
		options.pattern = {
			value: new window.RegExp(window.atob(pattern), patternmod),
			message: errormsg,
		};
	}

	if (required) {
		options.required = errormsg || 'Required';
	}

	let Tag = 'input';
	const TagProps = {
		...register(id, options),
		className: input,
	};

	if ('textarea' === kind) {
		Tag = 'textarea';
		TagProps.rows = 6;
	} else if ('select' === kind) {
		Tag = 'select';
		TagProps.children = selectOptions.split('|').map((i) => (
			<option key={i} value={i}>
				{i}
			</option>
		));
	}

	if (errors?.[id]) {
		TagProps.className += ' red';
	}

	return (
		<div className="ph2 pb3" style={{ width: `${width}%` }}>
			<label className="f5 mb1" htmlFor={id}>
				<span>
					{label} {required && <span className="red">*</span>}
				</span>
				<Tag {...TagProps} />
			</label>
			{errors?.[id] && (
				<span className="f6 pa2 red bg-near-white db">
					{errormsg || `${label} is invalid`}
				</span>
			)}
		</div>
	);
}

Field.propTypes = {
	field: PropTypes.object.isRequired,
};
