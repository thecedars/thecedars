import React, { useState, useCallback } from "react";
import { useAppContext } from "../Context";
import useNode from "./useNode";

export function Preloader() {
  const { preloader } = useAppContext();
  const [urls, setUrls] = useState([]);

  const addUrl = useCallback((_uri) => {
    setUrls((_p) => {
      if (!_p.includes(_uri)) {
        return [..._p, _uri];
      }

      return _p;
    });
  }, []);

  preloader.current.addUrl = addUrl;

  return urls.map((uri) => <Iteration key={`preloader-${uri}`} {...{ uri }} />);
}

function Iteration({ uri }) {
  useNode({ uri });

  return null;
}

export default Preloader;
