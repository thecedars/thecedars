import {
	useBlockProps,
	InspectorControls,
	RichText,
} from '@wordpress/block-editor';
import {
	PanelBody,
	PanelRow,
	ToggleControl,
	TextControl,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { useSettings } from '../../src/hooks';

/**
 * The Edit component function.
 *
 * Renders in the block editor.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {Function} props.setAttributes Function to update attribute state.
 */
export default function ButtonEdit( { attributes, setAttributes } ) {
	const { inverted, text, link } = attributes;
	const { button, buttonInverted } = useSettings();

	const className = inverted ? buttonInverted : button;

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'the-cedars' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<ToggleControl
							checked={ inverted }
							onChange={ () =>
								setAttributes( {
									...attributes,
									inverted: ! inverted,
								} )
							}
							label={ __( 'Inverted', 'the-cedars' ) }
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={ __( 'Button Link', 'the-cedars' ) }
							value={ link }
							onChange={ ( value ) =>
								setAttributes( {
									...attributes,
									link: value,
								} )
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<RichText
				{ ...{ className } }
				tagName="div"
				value={ text }
				onChange={ ( v ) =>
					setAttributes( { ...attributes, text: v } )
				}
				allowedFormats={ [] }
			/>
		</div>
	);
}
