import React from "react";
import { Anchor, Title, PageWidth } from "../components";
import PostContent from "./PostContent";

function CategoryListItem({ last, uri, name, children }) {
  const Wrap = uri ? Anchor : "span";

  let className = "category-item dib";

  if (!last) {
    className += " mr2 pr2 br b--near-white";
  }

  return (
    <li {...{ className }}>
      <Wrap href={uri} className="no-underline primary">
        {name || children}
      </Wrap>
    </li>
  );
}

export function SinglePost({ node }) {
  const { title, date, categories = {}, content } = node;

  const pageTitle = categories?.edges?.[0]?.node?.name || "Archives";

  return (
    <>
      <Title notHeading>{pageTitle}</Title>

      <PageWidth className="mv4">
        <div>
          <h1 className="mt0 mb4">{title}</h1>

          <div className="post-meta mv4">
            <div className="inline-flex items-center mt2 f6 mt0-ns">
              <div className="mr2">🕥</div>
              <div>{date}</div>
            </div>

            {~~categories?.edges?.length > 0 && (
              <div className="post-categories inline-flex items-center ml3">
                <div className="mr2">📁</div>
                <ul className="list pl0">
                  {categories.edges.map((category, index) => {
                    const last = index + 1 === categories.edges.length;
                    return (
                      <CategoryListItem
                        key={category.node.id}
                        {...{ last }}
                        {...category.node}
                      />
                    );
                  })}
                </ul>
              </div>
            )}
          </div>

          <PostContent className="mt4">{content}</PostContent>
        </div>
      </PageWidth>
    </>
  );
}

export default SinglePost;
