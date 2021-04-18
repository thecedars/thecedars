import React from "react";
import { Anchor, PageWidth } from "../components";
import { useSettings } from "../hooks";
import { gql, useQuery } from "@apollo/client";

const FooterMenu = gql`
  query FooterMenu {
    menuItems(where: { location: FOOTER_MENU }) {
      nodes {
        id
        url
        label
        connectedNode {
          node {
            __typename
          }
        }
      }
    }
  }
`;

function MenuLink({ url, label }) {
  const props = { className: "color-inherit no-underline db mh2" };

  props.href = url;

  return <Anchor {...props}>{label}</Anchor>;
}

function FooterColumn({ children, className = "" }) {
  return <div className={`w-100 w-third-l ${className}`}>{children}</div>;
}

export function Footer() {
  const { title, description } = useSettings();
  const { data } = useQuery(FooterMenu);
  const menu = data?.menuItems?.nodes || [];

  return (
    <footer id="footer">
      <div className="bg-gray white">
        <PageWidth>
          <div className="flex-l pv4">
            <FooterColumn>
              <div className="f3 mb2">{title}</div>
              <div>{description}</div>
            </FooterColumn>
            <FooterColumn className="ml-auto-l tr-l">
              <nav className="lh-copy">
                {menu.map((node) => (
                  <MenuLink key={node.id} {...node} />
                ))}
              </nav>
            </FooterColumn>
          </div>
        </PageWidth>
      </div>
      <div className="f7 white bg-mid-gray pv4">
        <PageWidth>
          <div className="flex-l items-center-l">
            <div>
              Copyright {new Date().getFullYear()}{" "}
              {title ? ` - ${title}` : "..."}
              <span> | All rights reserved</span>
            </div>

            <div className="ml-auto-l"></div>
          </div>
        </PageWidth>
      </div>
    </footer>
  );
}

export default Footer;
