import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {number} props.attributes.margin Vertical margin.
 */
export default function NoticeBannerSave( { attributes: { margin } } ) {
	let atts = '';

	if ( margin ) {
		atts += ` margin="${ margin }"`;
	}

	return (
		<div { ...useBlockProps.save() }>
			<RawHTML>{ `[cedars-notice-banner${ atts }]` }</RawHTML>
			<div className="flex-l items-center-l nl3 nr3 nt3 nb3">
				<InnerBlocks.Content />
			</div>
			<RawHTML>{ '[/cedars-notice-banner]' }</RawHTML>
		</div>
	);
}
