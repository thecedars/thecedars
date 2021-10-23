import { render, StrictMode } from '@wordpress/element';
import Form from './form/provider.js';
import DefaultFormLayout from './form-default.js';

const renderTarget = document.getElementById( 'contact-form' );

if ( renderTarget ) {
	render(
		<StrictMode>
			<Form>
				<DefaultFormLayout />
			</Form>
		</StrictMode>,
		renderTarget
	);
}
