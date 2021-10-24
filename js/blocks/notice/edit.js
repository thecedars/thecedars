import { InspectorControls, RichText } from '@wordpress/block-editor';
import {
	PanelBody,
	PanelRow,
	SelectControl,
	TextControl,
	Dashicon,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { icons } from './icons';

/**
 * The Edit component function.
 *
 * Renders in the block editor.
 *
 * @param {Object} props Block props.
 * @param {Object} props.attributes Attribute state.
 * @param {Function} props.setAttributes Function to update attribute state.
 */
export default function NoticeEdit( { attributes, setAttributes } ) {
	const { icon, title, subtitle, link } = attributes;

	return (
		<div className="w-third-l pa3">
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'the-cedars' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<SelectControl
							label={ __( 'Icon', 'spotlight' ) }
							value={ icon }
							onChange={ ( v ) =>
								setAttributes( { ...attributes, icon: v } )
							}
							options={ icons.map( ( i ) => ( {
								value: i,
								label: i,
							} ) ) }
						/>
					</PanelRow>
					<PanelRow>
						<div className="gray f7">
							<span>
								{ __(
									'For the full list of resources, visit ',
									'spotlight'
								) }
							</span>
							<a
								className="color-inherit"
								href="https://developer.wordpress.org/resource/dashicons/"
							>
								Dashicon Resources
							</a>
						</div>
					</PanelRow>

					<PanelRow>
						<TextControl
							label={ __( 'Link', 'spotlight' ) }
							value={ link }
							onChange={ ( v ) =>
								setAttributes( { ...attributes, link: v } )
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div>
				<div className="w-50 center mw3 mb4">
					<div className="br-100 bg-near-white aspect-ratio aspect-ratio--1x1">
						<span className="flex items-center justify-center aspect-ratio--object pointer">
							<Dashicon { ...{ icon } } className="primary" />
						</span>
					</div>
				</div>
				<div className="tc">
					<span className="no-underline">
						<RichText
							className="fw7 f4 white"
							tagName="div"
							value={ title }
							onChange={ ( v ) =>
								setAttributes( { ...attributes, title: v } )
							}
							allowedFormats={ [] }
						/>

						<RichText
							className="f5 moon-gray"
							tagName="div"
							value={ subtitle }
							onChange={ ( v ) =>
								setAttributes( { ...attributes, subtitle: v } )
							}
							allowedFormats={ [] }
						/>
					</span>
				</div>
			</div>
		</div>
	);
}
