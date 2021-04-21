import React from "react";
import { Button, PageWidth, Title } from "../components";
import { useLocation } from "react-router-dom";
import Archive from "./Archive";
import ErrorRouting from "./ErrorRouting";
import Seo from "./Seo";
import Single from "./Single";
import useNode from "./useNode";

export function Node(props) {
  const {
    databaseId,
    query,
    isArchive: isArchiveProp,
    perPage,
    nodeTitle,
    variables,
    skip,
    fetchPolicy,
    wrap: Wrap = React.Fragment,
  } = props || {};

  const { pathname } = useLocation();

  const {
    __typename,
    edges,
    node,
    error,
    loading,
    isArchiveNode,
    pageInfo,
    fetchMore,
  } = useNode({
    mainQuery: true,
    query,
    variables,
    skip,
    fetchPolicy,
    perPage,
    databaseId,
  });

  const { hasNextPage } = pageInfo;

  const isArchive = isArchiveNode || isArchiveProp;

  const title = nodeTitle || node.title || node.name || "";

  const seo = node.seo || {};

  if (!nodeTitle && loading && !seo.title) {
    seo.title = process.env.REACT_APP_TITLE
      ? `... - ${process.env.REACT_APP_TITLE}`
      : "...";
  }

  if (process.env.REACT_APP_TITLE && title && !seo.title) {
    seo.title = `${title} - ${process.env.REACT_APP_TITLE}`;
  }

  if (title && !seo.title) {
    seo.title = title;
  }

  const uri = node.uri || pathname;

  if (isArchive) {
    return (
      <>
        <Seo {...{ uri }} {...seo}>
          <meta name="robots" content="noindex" />
        </Seo>

        {loading || title ? <Title>{title}</Title> : null}

        <Wrap>
          <PageWidth>
            {error ? (
              <ErrorRouting {...{ error }} />
            ) : edges?.length === 0 && !loading ? (
              <div className="fw7 tc f4">Nothing found.</div>
            ) : (
              <>
                <Archive {...{ __typename, edges, loading }} />
                {hasNextPage && (
                  <div className="mt4 tc">
                    <Button
                      {...{ loading }}
                      onClick={() => {
                        fetchMore({
                          variables: {
                            after: pageInfo.endCursor,
                          },
                          notifyOnNetworkStatusChange: true,
                        });
                      }}
                    >
                      Load More
                    </Button>
                  </div>
                )}
              </>
            )}
          </PageWidth>
        </Wrap>
      </>
    );
  } else {
    if (!skip && (error || (!loading && !node?.id))) {
      return <ErrorRouting {...{ error, loading }} />;
    }

    return (
      <article
        className={`single ${__typename ? __typename?.toLowerCase() : "post"}-${
          node?.databaseId || "0"
        }`}
      >
        <Seo {...{ uri }} {...seo} />

        <Single {...{ __typename, node, loading }} {...props} />
      </article>
    );
  }
}

export default Node;
