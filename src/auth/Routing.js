import React from "react";
import { Route, Switch } from "react-router-dom";
import Logout from "./Logout";
import Register from "./Register";
import ForgotPassword from "./ForgotPassword";
import ResetPassword from "./ResetPassword";
import Login from "./Login";

export const LoginPathnames = [
  "/login",
  "/logout",
  "/register",
  "/forgot-password",
  "/rp/:key/:login",
];

export function AuthenticationRouting() {
  return (
    <div className="mv4 mw6 center">
      <Switch>
        <Route exact path="/logout">
          <Logout />
        </Route>

        <Route exact path="/login">
          <Login />
        </Route>

        <Route exact path="/register">
          <Register />
        </Route>

        <Route exact path="/forgot-password">
          <ForgotPassword />
        </Route>

        <Route exact path="/rp/:key/:login">
          <ResetPassword />
        </Route>

        <Route path="*"></Route>
      </Switch>
    </div>
  );
}

export default AuthenticationRouting;
