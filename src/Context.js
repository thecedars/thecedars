import React, {
  createContext,
  useContext,
  useState,
  useRef,
  useCallback,
} from "react";
import { Preloader } from "./node";
import { HelmetProvider } from "react-helmet-async";

const AppContext = createContext({});
export const useAppContext = () => useContext(AppContext);

export function AppProvider({ children }) {
  const [viewerId, setViewerId] = useState(0);
  const [capabilities, setCapabilities] = useState();
  const [preloadUri, setPreloadUri] = useState([]);
  const primaryData = useRef({});
  const search = useRef({});

  const addPreloadUri = useCallback((_uri) => {
    setPreloadUri((_p) => {
      if (!_p.includes(_uri)) {
        return [..._p, _uri];
      }

      return _p;
    });
  }, []);

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
          addPreloadUri,
        }}
      >
        {children}

        {preloadUri.map((uri) => (
          <Preloader key={`preloader-${uri}`} {...{ uri }} />
        ))}
      </AppContext.Provider>
    </HelmetProvider>
  );
}

export default AppProvider;
