import React, { cloneElement } from "react";

export function Field({ className, children, label, id, required }) {
  const childrenWithId = cloneElement(children, { id, required });
  return (
    <div {...{ className }}>
      <div className="mb2">
        {label && (
          <label htmlFor={id} className="f5 mb1">
            {label} {required && <span className="red">*</span>}
          </label>
        )}
        <div>{childrenWithId}</div>
      </div>
    </div>
  );
}

export default Field;
