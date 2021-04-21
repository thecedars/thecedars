import React from "react";
import { gql, useQuery } from "@apollo/client";

export function Ads() {
  const { data } = useQuery(Query);
  const ads = data?.ads?.nodes || [];

  return (
    <div className="ads">
      <div className="mb3 f4 fw7 tc">Sponsors</div>
      {ads.map(({ id, content }) => (
        <div key={id} className="flex items-center justify-center" dangerouslySetInnerHTML={{ __html: content }}></div>
      ))}
    </div>
  );
}

const Query = gql`
  query Ads {
    ads {
      nodes {
        id
        content
      }
    }
  }
`;

export default Ads;
