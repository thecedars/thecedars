import { gql, useQuery } from "@apollo/client";
import { useEffect } from "react";
import { useLocation } from "react-router-dom";
import { useAppContext } from "../Context";
import CreatePaginationQuery from "./CreatePaginationQuery";

export function useNode(props) {
  const {
    mainQuery,
    query: queryProp,
    databaseId: idProp,
    uri,
    perPage,
    variables: varProp = {},
    skip,
    fetchPolicy,
  } = props || {};

  const { primaryData } = useAppContext();
  const { pathname, search } = useLocation();
  const previewId = new URLSearchParams(search).get("p");

  const databaseId = previewId || idProp;

  const query = queryProp || (databaseId ? IdQuery : UriQuery);

  const variables = { ...varProp, first: perPage || 10 };

  if (databaseId) {
    variables.databaseId = databaseId;
  }

  if (uri) {
    variables.uri = uri;
  } else {
    variables.uri = pathname;
  }

  const { data, loading, error, fetchMore } = useQuery(query, {
    errorPolicy: "all",
    variables,
    skip,
    fetchPolicy,
  });

  if (mainQuery) {
    primaryData.current = { ...data, loading };
  }

  useEffect(() => {
    const _p = primaryData.current;
    return () => {
      if (mainQuery && _p?.node?.id === primaryData.current?.node?.id) {
        primaryData.current = {};
      }
    };
  }, [mainQuery, primaryData]);

  const node = data ? data.node || {} : {};
  let edges = data?.node?.posts
    ? data.node.posts.edges || []
    : data?.posts?.edges || [];

  if (~~variables.last > 0) {
    edges = [...edges].reverse();
  }

  const meta = { __typename: node.__typename, pageInfo: {} };

  if (node.posts) {
    meta.pageInfo = node.posts?.pageInfo || {};
    meta.__typename = node?.posts?.edges?.[0]?.node?.__typename || null;
    meta.title = node?.name;
    meta.seo = node?.seo;
    meta.isArchiveNode = true;
  } else if (data?.posts) {
    meta.pageInfo = data.posts.pageInfo || {};
    meta.__typename = data?.posts?.edges?.[0]?.node?.__typename || null;
    meta.isArchiveNode = true;
  }

  return {
    node,
    edges,
    loading,
    error,
    fetchMore,
    ...meta,
  };
}

export const LiteralSeo = `
  title
  metaDesc
  breadcrumbs {
    url
    text
  }
`;

export const FragmentPost = `
  fragment PostFragment on Post {
    id
    databaseId
    uri
    title
    excerpt
    content
    date
    isRestricted
    isPreview
    seo {
      ${LiteralSeo}
    }
    categories(first: 5) {
      edges {
        node {
          id
          databaseId
          slug
          name
          uri
        }
      }
    }
  }
`;

export const FragmentPage = `
  fragment PageFragment on Page {
    id
    databaseId
    uri
    title
    content
    seo {
      ${LiteralSeo}
    }
    template {
      templateName
    }
    featuredImage {
      node {
        id
        src: mediaItemUrl
        alt: altText
        srcSet
        sizes
      }
    }
  }
`;

export const FragmentContentType = `
  fragment ContentTypeFragment on ContentType {
    id
    title: graphqlPluralName
    ${CreatePaginationQuery("contentNodes", "...PostFragment")}
  }
`;

export const FragmentUserArchive = `
  fragment UserArchiveFragment on User {
    id
    name
    ${CreatePaginationQuery("posts", "...PostFragment")}
  }
`;

export const FragmentCategory = `
  fragment CategoryFragment on Category {
    id
    databaseId
    slug
    name
    uri
    seo {
      ${LiteralSeo}
    }
    ${CreatePaginationQuery("posts", "...PostFragment")}
  }
`;

export const FragmentTag = `
  fragment TagFragment on Tag {
    id
    databaseId
    slug
    name
    uri
    seo {
      ${LiteralSeo}
    }
    ${CreatePaginationQuery("posts", "...PostFragment")}
  }
`;

const UriQuery = gql`
  query Node(
    $uri: String!
    $first: Int
    $last: Int
    $after: String
    $before: String
  ) {
    node: nodeByUri(uri: $uri) {
      __typename
      ...PostFragment
      ...PageFragment
      ...CategoryFragment
      ...TagFragment
      ...ContentTypeFragment
      ...UserArchiveFragment
    }
    advancedCustomFields(uri: $uri)
  }
  ${FragmentContentType}
  ${FragmentCategory}
  ${FragmentTag}
  ${FragmentPage}
  ${FragmentPost}
  ${FragmentUserArchive}
`;

const IdQuery = gql`
  query ContentNodeId($databaseId: ID!) {
    node: contentNode(id: $databaseId, idType: DATABASE_ID) {
      __typename
      ...PostFragment
      ...PageFragment
    }
  }
  ${FragmentPage}
  ${FragmentPost}
`;

export default useNode;
