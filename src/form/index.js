import React, { lazy, Suspense } from 'react';

const FormDefault = lazy(() => import('./form.js'));

export default function Form(props) {
	return (
		<Suspense fallback={null}>
			<FormDefault {...props} />
		</Suspense>
	);
}
