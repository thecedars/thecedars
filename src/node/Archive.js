import React from "react";
import Card from "./Card";

export function Archive(props) {
  const { edges, loading } = props;

  return (
    <div>
      {~~edges?.length > 0 &&
        edges.map(({ node, cursor }) =>
          node.databaseId ? (
            <Card key={cursor} {...{ loading, node, cursor }} />
          ) : null
        )}
    </div>
  );
}

export default Archive;
