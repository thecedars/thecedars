import React from "react";

export function QuickLinks({ children }) {
  return (
    <div>
      <div className="w-50 center mw3 mb4">
        <div className="br-100 bg-near-white aspect-ratio aspect-ratio--1x1" />
      </div>
      <div className="tc">{children}</div>
    </div>
  );
}

export function QuickLinksTitle({children}) {
  return <div className="fw7 f4 white">{children}</div>
}

export function QuickLinksText({children}) {
  return <div className="f5 moon-gray">{children}</div>
}

export default QuickLinks;
