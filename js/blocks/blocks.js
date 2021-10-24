/**
 * WordPress dependencies.
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Import all the folders here that need to be blocks.
 */
import * as hero from './hero-image';
import * as pageContainer from './page-container';
import * as contactForm from './contact-form';
import * as button from './button';

/**
 * Editor Scss.
 */
import './common/editor.scss';

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	const { settings, name } = block;
	registerBlockType( name, settings );
};

/**
 * Add the imported folders here into this array.
 */
const blockRegistration = [ hero, pageContainer, contactForm, button ];

blockRegistration.forEach( registerBlock );
