import React, { useRef, useState } from "react";
import { gql, useMutation } from "@apollo/client";
import { Button } from "../components";
import { Field, Input } from "../form";
import BackToLogin from "./BackToLogin";
import Permissions from "./Permissions";
import AlreadyLoggedIn from "./AlreadyLoggedIn";

const Mutation = gql`
  mutation RegisterMutation(
    $clientMutationId: String!
    $username: String!
    $email: String!
  ) {
    registerUser(
      input: {
        clientMutationId: $clientMutationId
        username: $username
        email: $email
      }
    ) {
      user {
        id
        name
      }
    }
  }
`;

export function Register({ className }) {
  const input = useRef({});
  const [message, setMessage] = useState();

  const [mutate, { loading }] = useMutation(Mutation, {
    onCompleted: function () {
      setMessage("Registered! Please check your email for confirmation.");
    },
    onError: function (data) {
      setMessage(data.message);
    },
  });

  function Submit() {
    let pass = true;
    Object.values(input.current).forEach((field) => {
      if (field.error) {
        field.setError(true);
        pass = false;
      }
    });

    if (pass) {
      const variables = {
        clientMutationId: new Date().getTime().toString(36),
        username: input.current.username?.value || "",
        email: input.current.email?.value || "",
      };

      mutate({ variables });
    } else {
      setMessage("Please fill out all fields");
    }
  }

  return (
    <Permissions
      wait
      fallback={
        <div {...{ className }}>
          <div className="mb2 f3">Register</div>

          {message && <div className="mv2">{message}</div>}

          <Field id="username" label="Username">
            <Input id="username" ref={input} valid={(value) => value !== ""} />
          </Field>

          <Field id="email" label="Email">
            <Input
              id="email"
              type="email"
              errorMessage="Must be an email."
              valid={(value) =>
                /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(value || "")
              }
              onKeyDown={(event) => event.key === "Enter" && Submit()}
              ref={input}
            />
          </Field>

          <div className="tc">
            <Button {...{ loading }} onClick={Submit}>
              Register
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

export default Register;
