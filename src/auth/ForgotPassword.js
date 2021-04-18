import React, { useRef, useState } from "react";
import { gql, useMutation } from "@apollo/client";
import { Button } from "../components";
import { Field, Input } from "../form";
import BackToLogin from "./BackToLogin";
import AlreadyLoggedIn from "./AlreadyLoggedIn";
import Permissions from "./Permissions";

const Mutation = gql`
  mutation ForgotPasswordMutation(
    $clientMutationId: String!
    $username: String!
  ) {
    sendPasswordResetEmail(
      input: { clientMutationId: $clientMutationId, username: $username }
    ) {
      clientMutationId
    }
  }
`;

export function ForgotPassword({ className }) {
  const input = useRef({});
  const [message, setMessage] = useState();

  const [mutate, { loading }] = useMutation(Mutation, {
    onCompleted: function () {
      setMessage("Check your email for a password recovery email.");
    },
    onError: function (data) {
      setMessage(data.message);
    },
  });

  function Submit() {
    const variables = {
      clientMutationId: new Date().getTime().toString(36),
      username: input.current.username?.value || "",
    };

    if (variables.username) {
      mutate({ variables });
    } else {
      setMessage("You forgot to enter a username");
    }
  }

  return (
    <Permissions
      wait
      fallback={
        <div {...{ className }}>
          <div className="mb2 f3">Forgot Password</div>

          {message && <div className="mv2">{message}</div>}

          <div className="">Enter Your Username or Email</div>

          <Field id="username" label="Username">
            <Input
              id="username"
              ref={input}
              valid={(value) => value !== ""}
              onKeyDown={(event) => event.key === "Enter" && Submit()}
            />
          </Field>

          <div className="tc">
            <Button {...{ loading }} onClick={Submit}>
              Request New Password
            </Button>
          </div>

          <BackToLogin />
        </div>
      }
    >
      <AlreadyLoggedIn />
    </Permissions>
  );
}

export default ForgotPassword;
