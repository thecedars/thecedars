import React from "react";
import Submenu from "./Submenu";
import { Anchor } from "../components";
import { ReactComponent as Carat } from "./carat.svg";
import { useLocation } from "react-router-dom";
import { useMenuContext } from "./MenuContext";

export function MenuItem({ setHover, hover, className, item, subMenu = {} }) {
  const { pathname } = useLocation();
  const { isDesktop } = useMenuContext();

  const DivProps = { className: "relative", key: item.id };

  const AnchorProps = {
    className,
    onClick: () => setHover(item.id),
  };

  if (isDesktop) {
    AnchorProps.onMouseEnter = () => setHover(item.id);
  }

  const SpanProps = { className: "db" };

  if (
    process.env.REACT_APP_DOMAIN + pathname === item.url ||
    hover === item.id
  ) {
    AnchorProps.className += " primary";
  } else {
    AnchorProps.className += " color-inherit";
  }

  if (item.cssClasses?.length > 0) {
    SpanProps.className += " " + item.cssClasses.join(" ");
  }

  if (hover === item.id) {
    DivProps.className += " z-2";
  } else {
    DivProps.className += " z-1";
  }

  const hasChildren = ~~item.childItems?.nodes?.length > 0;

  return (
    <div {...DivProps}>
      <div className="flex items-center">
        <Anchor href={item.url} {...AnchorProps}>
          <span {...SpanProps}>{item.label}</span>
        </Anchor>
        {!isDesktop && hasChildren ? (
          <span
            className="ml-auto db pa1 pointer"
            onClick={() => setHover(item.id)}
          >
            <Carat />
          </span>
        ) : null}
      </div>

      {hasChildren && hover === item.id ? (
        <Submenu items={item.childItems.nodes} {...subMenu} />
      ) : null}
    </div>
  );
}

export default MenuItem;
