import { createContext, useContext } from "react";

export const SearchContext = createContext({});
export function useSearchContext() {
  return useContext(SearchContext);
}

export default SearchContext;
