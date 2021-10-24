import { useBlockProps } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {Object} props.attributes.padding Padding around Element.
 * @param {Object} props.attributes.defaultInquiry Selected inquiry on load.
 */
export default function ContactFormSave( {
	attributes: { padding, defaultInquiry },
} ) {
	let atts = '';

	if ( padding ) {
		atts += ` padding="${ padding }"`;
	}

	if ( defaultInquiry ) {
		atts += ` inquiry="${ defaultInquiry }"`;
	}

	return (
		<div { ...useBlockProps.save() }>
			<RawHTML>{ `[the-cedars-contact-form${ atts }][/the-cedars-contact-form]` }</RawHTML>
		</div>
	);
}
