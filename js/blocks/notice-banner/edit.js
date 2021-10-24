import {
	InspectorControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps, //eslint-disable-line
} from '@wordpress/block-editor';
import { PanelBody, PanelRow, RangeControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/**
 * The Edit component function.
 *
 * Renders in the block editor.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {Function} props.setAttributes Function to update attribute state.
 */
export default function NoticeBannerEdit( { attributes, setAttributes } ) {
	const { margin } = attributes;

	const innerBlocksProps = useInnerBlocksProps(
		{
			className: 'flex-l items-center-l nl3 nr3 nt3 nb3',
		},
		{
			orientation: 'horizontal',
			template: [
				[ 'the-cedars/notice', {} ],
				[ 'the-cedars/notice', {} ],
				[ 'the-cedars/notice', {} ],
			],
			allowedBlocks: [ 'the-cedars/notice' ],
			templateLock: 'insert',
		}
	);

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'the-cedars' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<RangeControl
							label={ __( 'Margin', 'the-cedars' ) }
							value={ margin }
							onChange={ ( value ) =>
								setAttributes( {
									...attributes,
									margin: value,
								} )
							}
							step={ 1 }
							min={ 0 }
							max={ 6 }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div
				className={ `br4 bg-secondary pa4 overflow-hidden light-gray mv${ margin }` }
			>
				<div { ...innerBlocksProps } />
			</div>
		</div>
	);
}
