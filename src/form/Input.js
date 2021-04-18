import React, {
  forwardRef,
  useCallback,
  useEffect,
  useReducer,
  useRef,
} from "react";
import { Input as InputComponent } from "../components";

function reducer(state, { error, value, ref, id, valid }) {
  if (typeof error !== "undefined") {
    if (ref?.current?.[id]) {
      ref.current[id].error = error;
      ref.current[id].value = state.value;
    }

    return { value: state.value, error };
  }

  const checkForError = (vv) => {
    let __error = false;

    if (typeof valid === "function") {
      __error = !valid(vv);
    }

    if (ref?.current?.[id]) {
      ref.current[id].error = __error;
      ref.current[id].value = vv;
    }

    return __error;
  };

  if (typeof value === "function") {
    const newValue = value(state.value);

    return { value: newValue, error: checkForError(newValue) };
  }

  return { value, error: checkForError(value) };
}

export const Input = forwardRef(function (p, ref) {
  const {
    type,
    className,
    errorMessage,
    valid,
    value: valueProp,
    id,
    children,
    onChange: onChangeProp,
    options,
    ..._props
  } = p;

  const element = useRef({});
  const [state, dispatch] = useReducer(reducer, { value: "", error: false });

  const setValue = useCallback(
    (value) => {
      dispatch({ value, ref, id, valid });
    },
    [valid, ref, id]
  );

  const setError = useCallback(
    (error) => {
      dispatch({ error, ref, id, valid });
    },
    [valid, ref, id]
  );

  useEffect(() => {
    if (valueProp) {
      setValue(valueProp);
    }
  }, [valueProp, setValue]);

  const props = {
    type,
    ref: element,
    value: state.value,
    id,
    ..._props,
  };

  props.onChange = (evt) => {
    setValue(evt.target.value);

    if (onChangeProp) {
      onChangeProp(evt);
    }
  };

  useEffect(() => {
    if (ref && id) {
      ref.current[id] = {
        id,
        error: typeof valid === "function" ? !valid(valueProp || "") : false,
        value: valueProp || "",
        element,
        setValue,
        setError,
      };
    }

    return () => {
      if (ref && id) {
        // eslint-disable-next-line
        delete ref.current[id];
      }
    };
    // eslint-disable-next-line
  }, [id]);

  return (
    <div {...{ className }}>
      <div>
        {type === "select" ? (
          <InputComponent {...props}>{options}</InputComponent>
        ) : (
          <InputComponent {...props} />
        )}
        {state.error && (
          <div className="pa2 red bg-near-white">
            {errorMessage || "Invalid Value"}
          </div>
        )}
      </div>
      {state.value && !state.error && children ? children : null}
    </div>
  );
});

export default Input;
