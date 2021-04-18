import React from "react";
import { PageWidth, Title } from "../components";
import PostContent from "./PostContent";
import SinglePost from "./SinglePost";

export function Single(props) {
  const { node } = props;
  const { title, content, name, __typename } = node;

  if (__typename === "Post") {
    return <SinglePost {...props} />;
  }

  return (
    <>
      <Title>{title || name}</Title>
      <PageWidth className="mv4">
        <PostContent className="mt4">{content}</PostContent>
      </PageWidth>
    </>
  );
}

export default Single;
