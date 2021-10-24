import {
	useBlockProps,
	InnerBlocks,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
} from '@wordpress/block-editor';
import {
	PanelBody,
	Button,
	PanelRow,
	RangeControl,
} from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useState, useEffect } from '@wordpress/element';
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
export default function HeroImageEdit( { attributes, setAttributes } ) {
	const { image: imageId, margin, title } = attributes;
	const [ image, setImage ] = useState();
	const [ siteTitle ] = useEntityProp( 'root', 'site', 'title' );

	useEffect( () => {
		const _getImage = async () => {
			const results = await apiFetch( {
				path: `wp/v2/media/${ imageId }`,
			} );

			const url =
				results?.media_details?.sizes?.large?.source_url ||
				results?.source_url;

			if ( url ) {
				setImage( url );
			}
		};

		if ( imageId ) {
			_getImage();
		}
	}, [ imageId ] );

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
										image: media.id,
									} )
								}
								allowedTypes={ [ 'image' ] }
								value={ imageId }
								render={ ( { open } ) => (
									<Button
										className="w-100 justify-center"
										isPrimary
										onClick={ open }
									>
										{ __( 'Set Image', 'the-cedars' ) }
									</Button>
								) }
							/>
						</MediaUploadCheck>
					</PanelRow>
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

			<div className={ `flex items-center mv${ margin }` }>
				<div className="flex-l items-center-l">
					<div className="w-60-l pr4-l mb4 mb0-l">
						<div className="ttu tracked">
							{ siteTitle }
							<span role="img" aria-label="Picture of a tree">
								🌲
							</span>
						</div>

						<RichText
							className="f1 f-5-l fw7 lh-solid mb3"
							tagName="div"
							value={ title }
							onChange={ ( v ) =>
								setAttributes( { ...attributes, title: v } )
							}
							allowedFormats={ [] }
						/>

						<div className="post-content mid-gray">
							<InnerBlocks
								template={ [
									[
										'core/paragraph',
										{
											content: 'Some text to play with.',
										},
									],
								] }
							/>
						</div>
					</div>
					<div className="w-40-l overflow-hidden br4 shadow-1 h5 h-auto-l animate__animated animate__slideInRight">
						<img
							src={ image }
							className="object-cover w-100 h-100 db"
							alt={ title }
						/>
					</div>
				</div>
			</div>
		</div>
	);
}
