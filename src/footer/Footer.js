import React from "react";
import { PageWidth } from "../components";
import { useSettings } from "../hooks";

export function Footer() {
  const { title } = useSettings();

  return (
    <footer id="footer">
      <div className="f7 white bg-mid-gray pv3">
        <PageWidth>
          <div className="flex items-center justify-center">
            <div>
              Copyright {new Date().getFullYear()}{" "}
              {title ? ` - ${title}` : "..."}
              <span> | All rights reserved</span>
            </div>
          </div>
        </PageWidth>
      </div>
    </footer>
  );
}

export default Footer;
