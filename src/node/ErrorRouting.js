import React from "react";
import { Loading } from "../components";
import { NotFound } from "./NotFound";

export function ErrorRouting(props) {
  const { loading, error, wrap } = props;
  const Wrap = wrap ? wrap : "div";

  if (loading) {
    return (
      <Wrap>
        <Loading />
      </Wrap>
    );
  }

  if (error) {
    return <Wrap className="tc f4 fw7">{error.message}</Wrap>;
  }

  return (
    <Wrap>
      <NotFound />
    </Wrap>
  );
}

export default ErrorRouting;
