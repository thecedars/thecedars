import React, { useState } from 'react';

import { PropTypes } from 'prop-types';
import { FormProvider, useForm } from 'react-hook-form';

import Button from '../app/button';
import Field from './field';
import loadRecaptcha from './recaptcha';

function FormLayout({ fields }) {
	return (
		<>
			{fields.map((field) => (
				<Field {...{ field }} key={field.id} />
			))}

			<div className="ph2 white flex justify-center w-100">
				<Button type="submit">Send Message</Button>
			</div>
		</>
	);
}

FormLayout.propTypes = {
	fields: PropTypes.array.isRequired,
};

export default function Form({ fields }) {
	const methods = useForm();
	const [error, setError] = useState();
	const [loading, setLoading] = useState(false);
	const [success, setSuccess] = useState();

	const onSubmit = async (data) => {
		setLoading(true);

		let gToken;

		try {
			gToken = await loadRecaptcha();
		} catch (e) {
			setLoading(false);
			setError(e.message);
			return;
		}

		let response;

		try {
			response = await fetch('/submission/index.php', {
				method: 'POST',
				body: JSON.stringify({ ...data, gToken }),
				headers: { 'content-type': 'application/json' },
			});

			if (response) {
				setError(null);
				setSuccess('The form was sent successfully.');
				methods.reset();
			}
		} catch (e) {
			setError(e.message);
			setSuccess(null);
		}

		setLoading(false);
	};

	return (
		<FormProvider {...methods}>
			<form
				onSubmit={methods.handleSubmit(onSubmit)}
				className="the-cedars-form"
			>
				<div className="flex nl2 nr2 flex-wrap">
					<FormLayout {...{ fields }} />
				</div>
				{loading && <>&hellip;</>}
				{error && (
					<div
						className="db mv2 bg-near-white red pa2 msg-error"
						dangerouslySetInnerHTML={{ __html: error }}
					/>
				)}
				{success && (
					<div className="mv2 flex items-center pa2 green bg-near-white msg-success">
						<span dangerouslySetInnerHTML={{ __html: success }} />
					</div>
				)}
			</form>
		</FormProvider>
	);
}

Form.propTypes = {
	fields: PropTypes.array.isRequired,
};
