import React, { memo } from "react";
import { Link } from "react-router-dom";
import { useNode } from "../node";

const PreloadWrap = memo(function ({ uri, children }) {
  useNode({ uri });
  return children;
});

export const Anchor = (existing) => {
  const props = { ...existing };

  let origin = null;

  try {
    ({ origin } = new URL(props.href));
  } catch (error) {
    if (props.href.indexOf("/") === 0) {
      origin = process.env.REACT_APP_DOMAIN;
      props.href = origin + props.href;
    }
  }

  if (origin.indexOf(process.env.REACT_APP_DOMAIN) === 0) {
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
