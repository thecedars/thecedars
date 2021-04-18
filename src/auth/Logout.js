import { gql, useMutation } from "@apollo/client";
import React, { useEffect, useState } from "react";
import { Redirect } from "react-router-dom";
import { useAppContext } from "../Context";

const Mutation = gql`
  mutation LogoutMutation($clientMutationId: String!) {
    logout(input: { clientMutationId: $clientMutationId }) {
      clientMutationId
      status
    }
  }
`;

export function Logout() {
  const { setCapabilities, setViewerId } = useAppContext();
  const [done, setDone] = useState();
  const [message, setMessage] = useState();

  const [logout] = useMutation(Mutation, {
    onCompleted: function (data) {
      if (data.logout?.status) {
        setDone(true);
        setCapabilities(null);
        setViewerId(0);
      }
    },
    onError: function (data) {
      setMessage(data.message);
    },
  });

  useEffect(() => {
    logout({
      variables: { clientMutationId: new Date().getTime().toString(36) },
    });
  }, [logout]);

  if (message) {
    return <div>{message}</div>;
  }

  if (done) {
    return <Redirect to="/" />;
  } else {
    return null;
  }
}

export default Logout;
