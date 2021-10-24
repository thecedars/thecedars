import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 */
export default function NoticeSave( { attributes } ) {
	let atts = '';

	for ( const _x of Object.keys( attributes ) ) {
		atts += ` ${ _x }="${ attributes[ _x ] }"`;
	}

	return <RawHTML>{ `[cedars-notice${ atts } /]` }</RawHTML>;
}
