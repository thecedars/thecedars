import { cloneElement, useEffect } from "react";
import { gql, useQuery } from "@apollo/client";
import { useAppContext } from "../Context";

const Query = gql`
  query PermissionsQuery {
    viewer {
      id
      databaseId
      capabilities
    }
  }
`;

export function Permissions({ wait, cap, children, fallback, authorId }) {
  const {
    capabilities,
    setCapabilities,
    viewerId,
    setViewerId,
  } = useAppContext();

  const { data, loading } = useQuery(Query, {
    errorPolicy: "all",
    fetchPolicy: "network-only",
    skip: ~~capabilities?.length > 0 && !viewerId,
  });

  useEffect(() => {
    const viewer = data?.viewer;

    if (viewer) {
      setCapabilities(viewer.capabilities || null);
      setViewerId(viewer.databaseId || 0);
    }
  }, [data, setCapabilities, setViewerId]);

  if (capabilities?.length > 0) {
    // If no cap is present, assume you just need to be logged in.
    if (!cap) {
      return children;
    }

    const capArray = Array.isArray(cap) ? cap : [cap];

    for (let i = 0; i < capArray.length; i++) {
      if (capabilities.includes(capArray[i])) {
        const others = capArray[i].replace("_", "_others_");
        if (authorId) {
          if (viewerId === authorId || capabilities.includes(others)) {
            return children;
          }
        } else {
          return children;
        }
      }
    }
  }

  if (wait && loading) {
    return null;
  }

  if (fallback) {
    return cloneElement(fallback, { loading });
  }

  return fallback || null;
}

export default Permissions;
