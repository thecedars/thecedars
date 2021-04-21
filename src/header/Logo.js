import React from "react";
import Menu from "./Menu";
import { useLocation } from "react-router-dom";
import { Anchor } from "../components";
import { useSettings } from "../hooks";
import { MenuProvider } from "./MenuContext";

export function Logo({h1}) {
  const { title, logo } = useSettings();
  const LogoContainer = h1 ? "h1" : "div";

  return (
    <LogoContainer className="ma0 lh-title f3">
      <Anchor href="/" className="no-underline db primary fw7">
        {logo ? (
          <img src={logo} alt={title} className="mw4 h2 h-auto-l db" />
        ) : (
          title
        )}
      </Anchor>
    </LogoContainer>
  );
}

export default Logo;
