import React from "react";
import { PostContent, useNode, Seo } from "../node";
import { PageWidth, Button } from "../components";
import { useSettings } from "../hooks";
import QuickLinks, { QuickLinksTitle, QuickLinksText } from "./QuickLinks";

export function Home() {
  const { description, title } = useSettings();
  const { node } = useNode({ mainQuery: true });

  const { src, alt, srcSet, sizes } = node.featuredImage?.node || {};

  return (
    <PageWidth>
      <Seo {...node.seo} />

      <div className="vh-75-l flex items-center pv6 pv0-l">
        <div className="flex-l items-center-l">
          <div className="w-60-l pr4-l mb4 mb0-l">
            {title && <div className="ttu tracked">{title} 🌲</div>}
            <div className="f1 f-5-l fw7 lh-solid mb3">{description}</div>

            <PostContent className="mid-gray fw7">{node.content}</PostContent>

            <div className="mt4 flex items-center">
              <Button className="mr3 nowrap">By-Laws</Button>

              <Button inverted>Covenants</Button>
            </div>
          </div>

          {src && (
            <div className="w-40-l overflow-hidden br4 shadow-1 h5 h-auto-l animate__animated animate__slideInRight">
              <img
                className="object-cover w-100 h-100 db"
                {...{ src, alt, srcSet, sizes }}
              />
            </div>
          )}
        </div>
      </div>

      <div className="br4 bg-secondary pa4 overflow-hidden light-gray mv5">
        <div className="flex-l items-center-l nl3 nr3 nt3 nb3">
          <div className="w-third-l pa3">
            <QuickLinks>
              <QuickLinksTitle>Budget</QuickLinksTitle>
              <QuickLinksText>lorum ipsum</QuickLinksText>
            </QuickLinks>
          </div>
          <div className="w-third-l pa3">
            <QuickLinks>
              <QuickLinksTitle>Garage Sale</QuickLinksTitle>
              <QuickLinksText>May 14-15</QuickLinksText>
            </QuickLinks>
          </div>
          <div className="w-third-l pa3">
            <QuickLinks>
              <QuickLinksTitle>Trash Pickup</QuickLinksTitle>
              <QuickLinksText>lorum ipsum</QuickLinksText>
            </QuickLinks>
          </div>
        </div>
      </div>
    </PageWidth>
  );
}

export default Home;
