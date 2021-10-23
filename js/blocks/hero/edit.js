import {
	InspectorControls,
	useBlockProps,
	MediaUpload,
	MediaUploadCheck,
	InnerBlocks,
} from '@wordpress/block-editor';
import {
	PanelBody,
	PanelRow,
	Button,
	RangeControl,
} from '@wordpress/components';
import { useState, useEffect, useMemo } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
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
export default function HeroEdit( { attributes, setAttributes } ) {
	const [ image, setImage ] = useState();
	const background = useMemo( () => attributes.background, [ attributes ] );
	const opacity = useMemo( () => attributes.opacity, [ attributes ] );

	useEffect( () => {
		const _getImage = async () => {
			const results = await apiFetch( {
				path: `wp/v2/media/${ background }`,
			} );

			const url =
				results?.media_details?.sizes?.large?.source_url ||
				results?.source_url;

			if ( url ) {
				setImage( url );
			}
		};

		if ( setImage && background ) {
			_getImage();
		}
	}, [ background ] );

	const containerProps = {
		className: 'b--blue pa4 relative z-1 ba bg-light-gray',
	};

	if ( image ) {
		containerProps.style = { backgroundImage: `url("${ image }")` };
		containerProps.className += ' cover bg-center';
	}

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'the-cedars' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<MediaUploadCheck>
							<MediaUpload
								onSelect={ ( media ) =>
									setAttributes( {
										...attributes,
										background: media.id,
									} )
								}
								allowedTypes={ ALLOWED_MEDIA_TYPES }
								value={ background }
								render={ ( { open } ) => (
									<Button
										className="w-100 justify-center"
										isPrimary
										label={ __(
											'Change background',
											'the-cedars'
										) }
										onClick={ open }
									>
										{ __(
											'Change background',
											'the-cedars'
										) }
									</Button>
								) }
							/>
						</MediaUploadCheck>
					</PanelRow>
					<PanelRow>
						<RangeControl
							label={ __(
								'Background Opacity',
								'the-cedars'
							) }
							value={ opacity || 0 }
							onChange={ ( value ) =>
								setAttributes( {
									...attributes,
									opacity: value,
								} )
							}
							step={ 5 }
							min={ 0 }
							max={ 100 }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div { ...containerProps }>
				<div className="relative z-2 h-100 pv4 white">
					<div className="pa4">
						<InnerBlocks />
					</div>
				</div>
				<div
					className="z-1 absolute absolute--fill bg-black"
					style={ { opacity: opacity ? opacity / 100 : 0 } }
				/>
			</div>
		</div>
	);
}

/**
 * List of Media types allowed on the image upload.
 *
 * @constant
 * @type {string[]}
 */
const ALLOWED_MEDIA_TYPES = [ 'image' ];
