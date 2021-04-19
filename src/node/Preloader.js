import useNode from "./useNode";

export function Preloader({ uri }) {
  useNode({ uri });

  return null;
}

export default Preloader;
