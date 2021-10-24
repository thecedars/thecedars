import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
	PanelBody,
	PanelRow,
	RangeControl,
	SelectControl,
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
export default function ContactFormEdit( { attributes, setAttributes } ) {
	const { padding, defaultInquiry } = attributes;
	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody
					title={ __( 'Settings', 'the-cedars' ) }
					initialOpen={ true }
				>
					<PanelRow>
						<RangeControl
							label={ __( 'Padding', 'the-cedars' ) }
							value={ padding }
							onChange={ ( value ) =>
								setAttributes( {
									...attributes,
									padding: value,
								} )
							}
							step={ 1 }
							min={ 0 }
							max={ 6 }
						/>
					</PanelRow>
					<PanelRow>
						<SelectControl
							label={ __( 'Default Inquiry', 'spotlight' ) }
							value={ defaultInquiry || '' }
							onChange={ ( v ) =>
								setAttributes( {
									...attributes,
									defaultInquiry: v,
								} )
							}
							options={ [
								'',
								'General',
								'Title Company',
								'Directory',
							].map( ( i ) => ( {
								value: i,
								label: i,
							} ) ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div className={ `pa${ padding }` }>
				<FauxContactForm />
			</div>
		</div>
	);
}

function FauxContactForm() {
	return (
		<div className="overflow-hidden">
			<FauxField required label={ __( 'Inquiry', 'the-cedars' ) } />
			<FauxField required label={ __( 'Name', 'the-cedars' ) } />
			<div className="flex-l nl2 nr2">
				<div className="ph2 w-50-l">
					<FauxField required label={ __( 'Email', 'the-cedars' ) } />
				</div>
				<div className="ph2 w-50-l">
					<FauxField label={ __( 'Phone', 'the-cedars' ) } />
				</div>
			</div>
			<div>
				<FauxField
					label={ __( 'Message', 'the-cedars' ) }
					rows={ 10 }
				/>
			</div>
		</div>
	);
}

function FauxField( { label, required, rows = 1 } ) {
	const { input } = useSettings();
	let innards = '';
	let count = rows;

	while ( count > 0 ) {
		innards += '&nbsp;<br/>';
		count--;
	}

	return (
		<div>
			<div className="mb2">
				<div className="f5 mb1">
					{ label } { required && <span className="red">*</span> }
				</div>
				<div
					className={ input }
					dangerouslySetInnerHTML={ { __html: innards } }
				/>
			</div>
		</div>
	);
}
