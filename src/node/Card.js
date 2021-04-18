import React from "react";
import { Anchor, Button } from "../components";
import PostContent from "./PostContent";

export function Card({ node }) {
  const { databaseId = 0, uri, title, date, excerpt, content } = node;
  const body = excerpt || content;

  return (
    <article className={`post-${databaseId} b--near-white bb pb4 mv4`}>
      <h2 className="mt0">
        <Anchor href={uri} className="primary no-underline">
          {title}
        </Anchor>

        {date && (
          <div className="flex items-center mt2 f6 fr-ns mt0-ns">
            <div className="mr2">🕥</div>
            <div>{date}</div>
          </div>
        )}
      </h2>

      <PostContent trim className="mv4">
        {body}
      </PostContent>

      <div className="tc tr-ns">
        <Button to={uri}>Read More</Button>
      </div>
    </article>
  );
}

export default Card;
