import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {number} props.attributes.background The background attachment ID.
 * @param {number} props.attributes.opacity The opacity percentage value.
 */
export default function HeroSave( { attributes: { background, opacity } } ) {
	const props = {
		...useBlockProps.save(),
	};

	return (
		<div { ...props }>
			<RawHTML>{ `[hero background="${ background }" opacity="${ opacity }"]` }</RawHTML>

			<div>
				<InnerBlocks.Content />
			</div>

			<RawHTML>{ '[/hero]' }</RawHTML>
		</div>
	);
}
