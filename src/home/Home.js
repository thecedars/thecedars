import React from "react";
import { PostContent, useNode, Seo } from "../node";
import { PageWidth } from "../components";

export function Home() {
  const { node } = useNode({ mainQuery: true });

  return (
    <PageWidth>
      <Seo {...node.seo} />
      <PostContent>{node.content}</PostContent>
    </PageWidth>
  );
}

export default Home;
