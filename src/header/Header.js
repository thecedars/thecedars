import React from "react";
import Menu from "./Menu";
import { useLocation } from "react-router-dom";
import { Anchor } from "../components";
import { useSettings } from "../hooks";
import { MenuProvider } from "./MenuContext";

export function Header({ className }) {
  const { pathname } = useLocation();
  const { title, logo } = useSettings();

  const LogoContainer = pathname === "/" ? "h1" : "div";

  return (
    <header id="header" {...{ className }}>
      <MenuProvider>
        <Menu>
          <LogoContainer className="ma0 lh-title f3">
            <Anchor href="/" className="no-underline db primary fw7">
              {logo ? <img src={logo} alt={title} className="mw4" /> : title}
            </Anchor>
          </LogoContainer>
        </Menu>
      </MenuProvider>
    </header>
  );
}

export default Header;
