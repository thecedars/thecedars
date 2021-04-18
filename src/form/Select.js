import React, { forwardRef } from "react";
import Input from "./Input";

export const Select = forwardRef(function ({ children, ...props }, ref) {
  return <Input type="select" options={children} {...{ ref }} {...props} />;
});

export default Select;
