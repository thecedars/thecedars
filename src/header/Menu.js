import React, { useEffect, useRef, useState } from "react";
import MenuItem from "./MenuItem";
import useMenu from "./useMenu";
import { useLocation } from "react-router-dom";
import { PageWidth } from "../components";
import { ReactComponent as Bars } from "./bars.svg";
import { useMenuContext } from "./MenuContext";

const hasAdminBar = !!document.getElementById("wpadminbar");

export function Menu({ children }) {
  const [open, setOpen] = useState();
  const [hover, setHover] = useState("");
  const prevPath = useRef();
  const { isDesktop, menuBar } = useMenuContext();
  const { pathname } = useLocation();
  const { menuItems } = useMenu({ location: "HEADER_MENU" });

  const DrawerBackground = { className: "relative-l z-2", style: {} };
  const MobileDrawer = { className: "", style: {} };

  /**
   * Closes menu on path change.
   */
  useEffect(() => {
    if (pathname !== prevPath.current) {
      setOpen(false);
    }
  }, [pathname]);

  /**
   * Updates the prevPath when pathname changes.
   */
  useEffect(() => {
    prevPath.current = pathname;
  }, [pathname]);

  if (open) {
    DrawerBackground.className += " db";
  } else {
    DrawerBackground.className += " dn db-l";
  }

  if (!isDesktop) {
    DrawerBackground.className +=
      " bg-white-30 absolute absolute--fill pointer";

    if (hasAdminBar) {
      DrawerBackground.style.top = "46px";
    }

    MobileDrawer.className += " bg-dark-gray white pa3 min-h-100";
    MobileDrawer.style.width = "50vw";
    MobileDrawer.style.cursor = "default";

    if (open) {
      MobileDrawer.className += " animate__animated animate__slideInLeft";
    }

    DrawerBackground.onClick = () => {
      setOpen(false);
    };

    MobileDrawer.onClick = (event) => {
      event.stopPropagation();
    };
  } else {
    DrawerBackground.onMouseLeave = () => setHover("");
  }

  return (
    <div>
      <div className="db dn-l bg-white pa2 ma2 br4" ref={menuBar}>
        <div className="flex items-center relative z-1">
          <div className="pointer absolute z-2" onClick={() => setOpen(!open)}>
            <Bars />
          </div>

          <div className="center h2">{children}</div>
        </div>
      </div>
      <PageWidth>
        <nav className="flex-l items-center-l justify-between-l w-100">
          <div className="dn db-l">{children}</div>
          <div {...DrawerBackground}>
            <div {...MobileDrawer}>
              <div className="ma0">
                <div className="flex-l items-center-l justify-between-l nowrap-l">
                  {menuItems.map((item, index) => (
                    <MenuItem
                      key={item.id}
                      className="db no-underline pv2 pv4-l ph3-l"
                      subMenu={{ className: "nt3-l" }}
                      {...{ item, hover, setHover, index }}
                    />
                  ))}
                </div>
              </div>
            </div>
          </div>
        </nav>
      </PageWidth>
    </div>
  );
}

export default Menu;
