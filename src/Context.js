import React, { createContext, useContext, useState, useRef } from "react";

const AppContext = createContext({});
export const useAppContext = () => useContext(AppContext);

export function AppProvider({ children }) {
  const [viewerId, setViewerId] = useState(0);
  const [capabilities, setCapabilities] = useState();
  const primaryData = useRef({});
  const search = useRef({});

  return (
    <AppContext.Provider
      value={{
        search,
        capabilities,
        setCapabilities,
        viewerId,
        setViewerId,
        primaryData,
      }}
    >
      {children}
    </AppContext.Provider>
  );
}

export default AppProvider;
