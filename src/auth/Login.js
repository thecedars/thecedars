import React, { useRef, useState } from "react";
import { Link } from "react-router-dom";
import { Button } from "../components";
import { Field, Input } from "../form";
import AlreadyLoggedIn from "./AlreadyLoggedIn";
import useLogin from "./useLogin";
import Permissions from "./Permissions";

export function Login({ className }) {
  const input = useRef({});
  const [message, setMessage] = useState();

  const { login, loading } = useLogin({ setMessage });

  function Submit() {
    login(input.current.username?.value, input.current.password?.value);
  }

  return (
    <Permissions
      wait
      fallback={
        <div {...{ className }}>
          <div className="mb2 f3">Login</div>

          {message && <div className="mv2">{message}</div>}

          <Field id="username" label="Username">
            <Input id="username" ref={input} valid={(value) => value !== ""} />
          </Field>

          <Field id="password" label="Password">
            <Input
              id="password"
              type="password"
              onKeyDown={(event) => event.key === "Enter" && Submit()}
              ref={input}
            />
          </Field>

          <div className="tc">
            <Button {...{ loading }} onClick={Submit}>
              Login
            </Button>
          </div>

          <div className="flex-ns justify-between-ns mt3">
            <Link to="/forgot-password" className="no-underline primary">
              Forgot Password
            </Link>
            <Link to="/register" className="no-underline primary">
              Sign up for an Account
            </Link>
          </div>
        </div>
      }
    >
      <AlreadyLoggedIn />
    </Permissions>
  );
}

export default Login;
