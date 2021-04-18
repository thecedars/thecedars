import React, { forwardRef } from "react";
import Input from "./Input";

export const Textarea = forwardRef(function (props, ref) {
  return <Input type="textarea" rows={5} {...{ ref }} {...props} />;
});

export default Textarea;
