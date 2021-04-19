import React from "react";
import { Anchor } from "../components";

export function QuickLinks({ children, href, icon: Icon }) {
  const Tag = href ? Anchor : "span";
  const TagProps = { href, className: "no-underline" };

  return (
    <div>
      <div className="w-50 center mw3 mb4">
        <div className="br-100 bg-near-white aspect-ratio aspect-ratio--1x1">
          <Tag
            {...{ href }}
            className={`flex items-center justify-center aspect-ratio--object ${
              href ? "pointer" : ""
            }`}
          >
            <Icon className="w2 fill-primary" />
          </Tag>
        </div>
      </div>
      <div className="tc">
        <Tag {...TagProps}>{children}</Tag>
      </div>
    </div>
  );
}

export function QuickLinksTitle({ children }) {
  return <div className="fw7 f4 white">{children}</div>;
}

export function QuickLinksText({ children }) {
  return <div className="f5 moon-gray">{children}</div>;
}

export default QuickLinks;
