import React, { forwardRef, useCallback, useEffect, useReducer } from "react";

function reducer(state, { error, value, ref, multiple, id, valid }) {
  if (typeof error !== "undefined") {
    if (ref?.current?.[id]) {
      ref.current[id].error = error;
      ref.current[id].value = state.value;
    }

    return { value: state.value, error };
  }

  const checkForError = (vv) => {
    let __error = false;

    const sanitizedValue = ~~vv.length === 1 ? vv[0] : vv;

    if (typeof valid === "function") {
      __error = !valid(sanitizedValue);
    }

    if (ref?.current?.[id]) {
      ref.current[id].error = __error;
      if (multiple) {
        ref.current[id].value = vv;
      } else {
        ref.current[id].value = sanitizedValue;
      }
    }

    return __error;
  };

  if (typeof value === "function") {
    const newValue = value(state.value);

    return { value: newValue, error: checkForError(newValue) };
  }

  return { value, error: checkForError(value) };
}

export const Checkbox = forwardRef(function (
  {
    id,
    className,
    options,
    multiple,
    onChange: onChangeProp,
    value: valueProp,
    valid,
    errorMessage,
    children,
    ...props
  },
  ref
) {
  const [state, dispatch] = useReducer(reducer, { value: [], error: false });

  const setValue = useCallback(
    (value) => {
      dispatch({ value, ref, multiple, id, valid });
    },
    [valid, ref, id, multiple]
  );

  const setError = useCallback(
    (error) => {
      dispatch({ error, ref, id, valid });
    },
    [valid, ref, id]
  );

  useEffect(() => {
    if (valueProp) {
      setValue((current) => {
        if (Array.isArray(valueProp)) {
          return [...current, ...valueProp];
        } else if (multiple) {
          return [...current, valueProp];
        } else {
          return [valueProp];
        }
      });
    }
  }, [valueProp, setValue, multiple]);

  const onChange = (event) => {
    const target = event.target;
    let v = [];

    if (target.checked) {
      if (state.value.includes(target.value)) {
        v = state.value;
      } else {
        if (multiple) {
          v = [...state.value, target.value];
        } else {
          v = [target.value];
        }
      }
    } else {
      v = state.value.filter((item) => item !== target.value);
    }

    setValue(v);

    if (onChangeProp) {
      onChangeProp(event);
    }
  };

  useEffect(() => {
    if (ref && id) {
      ref.current[id] = {
        id,
        error: typeof valid === "function" ? !valid(valueProp || "") : false,
        value: valueProp || "",
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
      <div className="flex flex-wrap nt1 nb1">
        {options.map((option, index) => {
          const optionValue = option?.value || option;
          return (
            <div key={optionValue} className="pa1">
              <label htmlFor={`${id}-${index}`} className="pointer">
                <input
                  value={optionValue}
                  checked={state.value.includes(optionValue)}
                  id={`${id}-${index}`}
                  name={id}
                  type={multiple ? "checkbox" : "radio"}
                  {...{ onChange }}
                  {...props}
                />
                <span className="ml2 dib">{option?.label || option}</span>
              </label>
              {state.error && (
                <div className="pa2 red bg-near-white">
                  {errorMessage || "Invalid Value"}
                </div>
              )}
            </div>
          );
        })}
      </div>
      {~~state.value.length > 0 && !state.error && children ? children : null}
    </div>
  );
});

export default Checkbox;
