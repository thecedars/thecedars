import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {number} props.attributes.image The background image id.
 * @param {number} props.attributes.margin Vertical margin.
 * @param {number} props.attributes.title Title text.
 */
export default function HeroImageSave( {
	attributes: { image, margin, title },
} ) {
	let atts = '';

	if ( image ) {
		atts += ` image="${ image }"`;
	}

	if ( margin ) {
		atts += ` margin="${ margin }"`;
	}

	if ( title ) {
		atts += ` title="${ title }"`;
	}

	return (
		<div { ...useBlockProps.save() }>
			<RawHTML>{ `[cedars-image-hero${ atts }]` }</RawHTML>
			<div>
				<InnerBlocks.Content />
			</div>
			<RawHTML>{ '[/cedars-image-hero]' }</RawHTML>
		</div>
	);
}
