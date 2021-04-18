import React, { forwardRef } from "react";

export const PageWidth = forwardRef(function (props, ref) {
  const { children, className } = props;

  return (
    <div className={`w-100 mw8 ph3 center ${className || ""}`} {...{ ref }}>
      {children}
    </div>
  );
});

export default PageWidth;
