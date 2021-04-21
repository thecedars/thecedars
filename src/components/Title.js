import React, { forwardRef } from "react";
import PageWidth from "./PageWidth";

export const Title = forwardRef((p, ref) => {
  const { notHeading, className = "", children, ...props } = p;
  const Wrap = notHeading ? "div" : "h1";

  return (
    <div className={`mb4 ${className}`} {...props}>
      <PageWidth>
        <Wrap className="ma0 lh-solid">
          <span {...{ ref }} className="f3 fw4 db">
            {children}
          </span>
        </Wrap>
      </PageWidth>
    </div>
  );
});

export default Title;
