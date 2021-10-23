import { useState, useEffect, useRef, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import Ajv from 'ajv';
import addFormats from 'ajv-formats';
import { FormContext } from './context';
import RecaptchaProvider, { useRecaptcha } from './recaptcha';

/**
 * Form context.
 *
 * @param {Object} props JSX properties.
 * @param {Object} props.children JSX.
 * @param {string} props.formName Form name to use for submission.
 * @return {Object} JSX.
 */
function FormProvider( { children, formName = 'default' } ) {
	const [ schema, setSchema ] = useState( { required: [], properties: {} } );
	const [ errorMessages, setErrorMessages ] = useState( {} );
	const [ loading, setLoading ] = useState();
	const [ { error, success }, setStatus ] = useState( {} );
	const [ form, setForm ] = useState( {} );
	const { getToken, usesRecaptcha } = useRecaptcha();
	const validate = useRef();
	const emptyForm = useRef( {} );

	/**
	 * Updates the field with setForm.
	 *
	 * @param {string} field The id of the field.
	 * @param {string} value Value being set.
	 */
	const updateField = useCallback(
		( field, value ) => {
			setForm( { ...form, [ field ]: value } );
		},
		[ form ]
	);

	// Gets the schema for the form.
	useEffect( () => {
		const _getSchema = async () => {
			try {
				const results = await apiFetch( {
					path: `the-cedars/v1/form-schema/${ formName }`,
				} );

				validate.current = ajv.compile( results.schema );
				const properties = results.schema.properties;

				const fields = {};
				for ( const id in properties ) {
					const type = properties[ id ].type;
					if ( type === 'string' ) {
						fields[ id ] = '';
					} else if ( type === 'number' ) {
						fields[ id ] = 0;
					} else if ( type === 'boolean' ) {
						fields[ id ] = false;
					}
				}

				emptyForm.current = { ...fields };
				setForm( fields );
				setSchema( results.schema );
				setErrorMessages( results.errorMessages );
			} catch ( e ) {
				setStatus( { error: [ e.message ] } );
			}
		};

		_getSchema();
	}, [ formName ] );

	/**
	 * @typedef validityReport
	 * @type {Array}
	 * @property {boolean} 0 - Whether this was a success.
	 * @property {Array} 1 - Errors, if any.
	 */

	/**
	 * Validates against the schema for a field and value.
	 * Uses the examples in the schema to only check the current field.
	 *
	 * @param {string} field Field id.
	 * @param {string} value Field value.
	 * @return {validityReport} Result of validity check.
	 */
	const validateField = ( field, value ) => {
		const mockData = { ...schema.examples[ 0 ] };
		mockData[ field ] = value;
		const valid = validate.current( mockData );

		return [ valid, validate.current?.errors ];
	};

	// Submission.
	const onSubmit = () => {
		const _submit = async () => {
			const dataSubmission = { ...form };

			try {
				if ( usesRecaptcha ) {
					dataSubmission.gToken = await getToken();
				}

				const results = await apiFetch( {
					path: `the-cedars/v1/form/${ formName }`,
					method: 'POST',
					data: dataSubmission,
				} );

				if ( results ) {
					setStatus( {
						success: __(
							'Thank you, someone from will contact you shortly.',
							'the-cedars'
						),
					} );
					setForm( { ...emptyForm.current } );
				}
			} catch ( e ) {
				const _message = [ e.message ];

				if ( e.additional_errors ) {
					for ( const __i of e.additional_errors ) {
						_message.push( __i.message );
					}
				}

				setStatus( { error: _message } );
			}

			setLoading( false );
		};

		setLoading( true );
		_submit();
	};

	return (
		<RecaptchaProvider>
			<FormContext.Provider
				value={ {
					loading,
					form,
					onSubmit,
					updateField,
					schema,
					errorMessages,
					validateField,
				} }
			>
				<div>
					{ !! error?.length && (
						<div className="mv3">
							{ error.map( ( e ) => (
								<div className="f6 fw7 red" key={ e }>
									{ e }
								</div>
							) ) }
						</div>
					) }
					{ success && (
						<div className="f3 fw7 green">{ success }</div>
					) }
				</div>
				{ !! schema.$id && children }
			</FormContext.Provider>
		</RecaptchaProvider>
	);
}

/**
 * Wrapper for the FormProvider to layer on the RecaptchaProvider.
 *
 * @param {Object} props JSX props.
 * @return {Object} JSX.
 */
export default function Form( props ) {
	return (
		<RecaptchaProvider>
			<FormProvider { ...props } />
		</RecaptchaProvider>
	);
}

const ajv = new Ajv();
addFormats( ajv );
