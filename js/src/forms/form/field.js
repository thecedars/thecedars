import {
	useState,
	useContext,
	cloneElement,
	Fragment,
} from '@wordpress/element';
import { Input } from '../../components';
import { FormContext } from './context.js';

export function Field( {
	id,
	className,
	rows = 1,
	options,
	WhenValid = Fragment,
} ) {
	const [ error, setError ] = useState();
	const {
		form,
		updateField,
		schema,
		validateField,
		errorMessages,
	} = useContext( FormContext );

	const value = form[ id ];
	const required = schema.required.includes( id );
	const label = schema.properties[ id ]?.title;
	let type;

	switch ( schema.properties[ id ]?.type ) {
		case 'number':
			type = 'number';
			break;
		default:
			type = rows === 1 ? 'text' : 'textarea';
	}

	/**
	 * onChange of the input.
	 *
	 * @param {Object} evt Event.
	 */
	const onChange = ( evt ) => {
		const va = evt.target.value;

		const [ valid, errors ] = validateField( id, va );

		updateField( id, va );

		if ( ! valid ) {
			const _errmsgs = [];

			if ( errorMessages[ id ] ) {
				_errmsgs.push( errorMessages[ id ] );
			} else {
				for ( const _errmsg of errors ) {
					_errmsgs.push( _errmsg.message );
				}
			}

			setError( _errmsgs.join( ', ' ) );
		} else {
			setError( null );
		}
	};

	return (
		<div { ...{ className } }>
			<BasicField { ...{ id, label, required } }>
				<Input { ...{ value, onChange, type, options, rows } } />
			</BasicField>
			{ error && <div className="red f7 fw7">{ error }</div> }
			{ ! error && !! value && <WhenValid /> }
		</div>
	);
}

export function BasicField( { className, children, label, id, required } ) {
	const childrenWithId = cloneElement( children, { id, required } );
	return (
		<div { ...{ className } }>
			<div className="mb2">
				{ label && (
					<label htmlFor={ id } className="f5 mb1">
						{ label } { required && <span className="red">*</span> }
					</label>
				) }
				<div>{ childrenWithId }</div>
			</div>
		</div>
	);
}

export default Field;
