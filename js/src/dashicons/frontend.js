import { Dashicon } from '@wordpress/components';
import { render, StrictMode } from '@wordpress/element';

const renderTargets = document.querySelectorAll( '.dashicon' );

if ( renderTargets?.length ) {
	for ( const renderTarget of renderTargets ) {
		render(
			<StrictMode>
				<Dashicon icon={ renderTarget.getAttribute( 'data-icon' ) } />
			</StrictMode>,
			renderTarget
		);
	}
}
