import React, { createContext, useContext, useState, useRef } from "react";
import { HelmetProvider } from "react-helmet-async";
import { Preloader } from "./node";

const AppContext = createContext({});
export const useAppContext = () => useContext(AppContext);

export function AppProvider({ children }) {
  const [viewerId, setViewerId] = useState(0);
  const [capabilities, setCapabilities] = useState();
  const primaryData = useRef({});
  const search = useRef({});
  const preloader = useRef({});

  return (
    <HelmetProvider>
      <AppContext.Provider
        value={{
          search,
          capabilities,
          setCapabilities,
          viewerId,
          setViewerId,
          primaryData,
          preloader,
        }}
      >
        {children}
        <Preloader />
      </AppContext.Provider>
    </HelmetProvider>
  );
}

export default AppProvider;
