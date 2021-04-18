import { gql } from "@apollo/client";
import React, { useEffect, useState } from "react";
import { useAppContext } from "../Context";
import { CreatePaginationQuery, FragmentPage, FragmentPost } from "../node";
import SearchContext from "./Context";
import SearchForm from "./SearchForm";
import Node from "../node";

export function Search() {
  const [filter, setFilter] = useState("");
  const { search } = useAppContext();

  search.current.updateSearch = setFilter;
  search.current.filter = filter;

  /* eslint-disable react-hooks/exhaustive-deps */
  // Removes function from the ref to prevent use when unmounted.
  useEffect(() => {
    return () => {
      delete search.current.updateSearch;
      delete search.current.filter;
    };
  }, [search]);
  /* eslint-enable react-hooks/exhaustive-deps */

  return (
    <SearchContext.Provider value={{ filter, setFilter }}>
      <Node
        isArchive
        query={Query}
        nodeTitle="Search"
        variables={{ filter }}
        skip={filter.length < 4}
        wrap={SearchForm}
      />
    </SearchContext.Provider>
  );
}

const Query = gql`
  query Search(
    $filter: String!
    $first: Int
    $last: Int
    $after: String
    $before: String
  ) {
    ${CreatePaginationQuery(
      "contentNodes",
      `
        __typename
        ...PostFragment
        ...PageFragment
      `,
      "status: PUBLISH, search: $filter"
    )}
  }
  ${FragmentPage}
  ${FragmentPost}
`;

export default Search;
