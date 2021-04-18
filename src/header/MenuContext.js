import React, { useState, useEffect, useRef } from "react";
import { useContext, createContext } from "react";

const MenuContext = createContext({});

export function useMenuContext() {
  return useContext(MenuContext);
}

export function MenuProvider({ children }) {
  const menuBar = useRef();
  const [isDesktop, setIsDesktop] = useState(true);

  /**
   * Effect to update "isDesktop" state.
   */
  useEffect(() => {
    let timeout;

    const UpdateView = () => {
      clearTimeout(timeout);

      timeout = setTimeout(() => {
        if (menuBar.current) {
          setIsDesktop(menuBar.current.offsetParent === null);
        }
      }, 25);
    };

    UpdateView();
    window.addEventListener("resize", UpdateView);

    return () => {
      clearTimeout(timeout);
      window.removeEventListener("resize", UpdateView);
    };
  }, []);

  return (
    <MenuContext.Provider value={{ isDesktop, menuBar }}>
      {children}
    </MenuContext.Provider>
  );
}
