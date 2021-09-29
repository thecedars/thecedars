import React, { useEffect } from "react";
import { Link } from "react-router-dom";
import { useAppContext } from "../Context";

function PreloadWrap({ uri, children }) {
  const { preloader } = useAppContext();

  useEffect(() => {
    if (preloader.current.addUrl) {
      preloader.current.addUrl(uri);
    }
  }, [uri, preloader]);

  return children;
}

export const Anchor = (existing) => {
  const props = { ...existing };

  let origin = null;

  if (props.href) {
    if (props.href.indexOf("/") === 0) {
      origin = window.__WP.SITE_URL;
      props.href = origin + props.href;
    } else {
      ({ origin } = new URL(props.href));
    }
  }

  if (origin.indexOf(window.__WP.SITE_URL) === 0) {
    const to = props.href.replace(origin, "");

    return (
      <PreloadWrap uri={to}>
        <Link {...{ to }} {...props} href={null} />
      </PreloadWrap>
    );
  }

  if (!props.target && props.href.indexOf("tel") !== 0) {
    props.target = "_new";
  }

  if (!props.rel) {
    props.rel = "noopen nofollow";
  }

  // eslint-disable-next-line
  return <a {...props} />;
};

export default Anchor;
