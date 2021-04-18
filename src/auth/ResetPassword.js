import React, { useMemo, useRef, useState } from "react";
import { gql, useMutation } from "@apollo/client";
import { useParams } from "react-router-dom";
import { Button } from "../components";
import { Field, Input } from "../form";
import BackToLogin from "./BackToLogin";
import Permissions from "./Permissions";
import AlreadyLoggedIn from "./AlreadyLoggedIn";

const Mutation = gql`
  mutation ResetPasswordMutation(
    $clientMutationId: String!
    $key: String!
    $login: String!
    $password: String!
  ) {
    resetUserPassword(
      input: {
        clientMutationId: $clientMutationId
        key: $key
        login: $login
        password: $password
      }
    ) {
      clientMutationId
    }
  }
`;

function GeneratePassword(props) {
  const { length = 12, specialChars = true, extraSpecialChars = false } =
    props || {};
  let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  if (specialChars) {
    chars += "!@#$%^&*()";
  }
  if (extraSpecialChars) {
    chars += "-_ []{}<>~`+=,.;:/?|";
  }

  const max = chars.length;
  const min = 0;

  let password = "";
  for (let i = 0; i < length; i++) {
    password += chars.substr(Math.floor(Math.random() * (max - min) + min), 1);
  }

  return password;
}

export function ResetPassword({ className }) {
  const { key, login } = useParams();
  const input = useRef({});
  const [message, setMessage] = useState();
  const [completed, setCompleted] = useState();
  const InitialPassword = useMemo(() => GeneratePassword(), []);

  const [mutate, { loading }] = useMutation(Mutation, {
    onCompleted: function () {
      setCompleted(true);
    },
    onError: function (data) {
      setMessage(data.message);
    },
  });

  function Submit() {
    const variables = {
      clientMutationId: new Date().getTime().toString(36),
      key,
      login,
      password: input.current.password?.value || "",
    };

    mutate({ variables });
  }

  return (
    <Permissions
      wait
      fallback={
        <div {...{ className }}>
          {completed ? (
            <>
              <div className="tc mb3">
                You have successfully changed you password. Use the button below
                to login with your new credentials.
              </div>
              <div className="tc">
                <Button to="/login">Back To Login</Button>
              </div>
            </>
          ) : (
            <>
              <div className="mb2 f3">Reset Password</div>

              {message && <div className="mv2">{message}</div>}

              <div>Enter Your New Password</div>

              <Field id="password">
                <Input
                  id="password"
                  value={InitialPassword}
                  onKeyDown={(event) => event.key === "Enter" && Submit()}
                  ref={input}
                />
              </Field>

              <div className="tc">
                <Button {...{ loading }} onClick={Submit}>
                  Login
                </Button>
              </div>

              <BackToLogin />
            </>
          )}
        </div>
      }
    >
      <AlreadyLoggedIn />
    </Permissions>
  );
}

export default ResetPassword;
