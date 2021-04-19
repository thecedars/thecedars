import React from "react";
import { useLocation } from "react-router";

export function Main({ children }) {
  const { pathname } = useLocation();

  if ("/" === pathname) {
    return (
      <div className="main lh-copy relative z-1 flex-auto">{children}</div>
    );
  } else {
    return (
      <div className="main lh-copy relative z-1 flex-auto flex items-center justify-center">
        <div className="w-100 mw7 br3 pa4 mv3 center bg-white shadow-1">{children}</div>
      </div>
    );
  }
}

export default Main;
