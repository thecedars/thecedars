import React from "react";
import { Button, Loading, PageWidth, Input } from "../components";
import { useAppContext } from "../Context";
import { useSearchContext } from "./Context";
import NoSearchResults from "./NoSearchResults";

export function SearchForm({ children }) {
  const { primaryData: data } = useAppContext();
  const { filter, setFilter } = useSearchContext();

  const edges = data.current?.posts?.edges || [];
  const loading = data?.current?.loading;

  return (
    <>
      <PageWidth className="mv4">
        <div className="flex items-center">
          <Input
            type="search"
            value={filter}
            onChange={(event) => setFilter(event.target.value)}
          />
          <Button className="ml2">🔎</Button>
        </div>
      </PageWidth>

      {loading && edges.length === 0 ? (
        <div className="tc">
          <Loading />
        </div>
      ) : edges.length === 0 && (filter || "").length < 3 ? (
        <NoSearchResults />
      ) : (
        children
      )}
    </>
  );
}

export default SearchForm;
