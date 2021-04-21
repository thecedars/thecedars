import React from "react";
import Menu from "./Menu";
import Logo from "./Logo";
import { useLocation } from "react-router-dom";
import { MenuProvider } from "./MenuContext";

export function Header({ className }) {
  const { pathname } = useLocation();

  return (
    <header id="header" {...{ className }}>
      <MenuProvider>
        <Menu>
          <Logo h1={pathname === "/"} />
        </Menu>
      </MenuProvider>
    </header>
  );
}

export default Header;
