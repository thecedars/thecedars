import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';
import metadata from './block.json';

const { name } = metadata;

export { name };

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
export const settings = {
	...metadata,
	edit: Edit,
	save: Save,
};

function Edit() {
	return (
		<div { ...useBlockProps() }>
			<div className="center" style={ { maxWidth: '860px' } }>
				<div className="b--white ba b--dashed">
					<div className="ph3 b--black ba overflow-hidden b--dashed">
						<InnerBlocks
							template={ [ [ 'core/paragraph', {} ] ] }
							templateLock={ false }
						/>
					</div>
				</div>
			</div>
		</div>
	);
}

function Save() {
	return (
		<div { ...useBlockProps.save() }>
			<RawHTML>{ '[contained]' }</RawHTML>
			<div>
				<InnerBlocks.Content />
			</div>
			<RawHTML>{ '[/contained]' }</RawHTML>
		</div>
	);
}
