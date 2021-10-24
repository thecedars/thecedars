import { useBlockProps } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {boolean} props.attributes.inverted Whether the button should be on white instead of primary.
 * @param {number} props.attributes.text Text inside the button.
 * @param {number} props.attributes.link Button link.
 */
export default function ButtonSave( { attributes: { inverted, text, link } } ) {
	let atts = '';

	if ( inverted ) {
		atts += ` inverted="1"`;
	}

	if ( text ) {
		atts += ` text="${ text }"`;
	}

	if ( link ) {
		atts += ` link="${ link }"`;
	}

	return (
		<div { ...useBlockProps.save() }>
			<RawHTML>{ `[cedars-button${ atts } /]` }</RawHTML>
		</div>
	);
}
