import React, { forwardRef } from "react";

const InputClasses =
  "db w-100 f5 ba pa2 border-box bg-transparent b--moon-gray";

export const Input = forwardRef(function (
  { type, className: classNameProp, ...props },
  ref
) {
  const className = `${InputClasses} ${classNameProp || ""}`;

  const ComponentProps = { ref, className, ...props };

  switch (type) {
    case "select":
      return <select {...ComponentProps} />;
    case "textarea":
      return <textarea {...ComponentProps} />;
    default:
  }

  ComponentProps.type = type;

  return <input {...ComponentProps} />;
});

export default Input;
