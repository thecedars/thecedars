import React from "react";
import { PageWidth, Title } from "../components";
import PostContent from "./PostContent";
import SinglePost from "./SinglePost";
import Form from "../form";

export function Single(props) {
  const { node } = props;
  const { title, content, name, __typename, template } = node;

  if (__typename === "Post") {
    return <SinglePost {...props} />;
  }

  return (
    <>
      <Title>{title || name}</Title>
      <PageWidth className="mv4">
        <PostContent className="mt4">{content}</PostContent>

        {template?.templateName === "Contact" && (
          <div className="mt4">
            <Form />
          </div>
        )}
      </PageWidth>
    </>
  );
}

export default Single;
