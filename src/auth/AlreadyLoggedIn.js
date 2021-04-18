import React from "react";
import Permissions from "./Permissions";
import { Button } from "../components";

export function AlreadyLoggedIn() {
  return (
    <div>
      <div className="mb4 f2 tc fw7 lh-title">You are logged in.</div>
      <div className="flex-ns justify-between-ns">
        <Button to="/">Home</Button>
        <Permissions cap={["manage_options", "editor"]}>
          <Button href="/wp-admin/index.php">WP Admin</Button>
        </Permissions>
        <Button to="/logout">Logout</Button>
      </div>
    </div>
  );
}

export default AlreadyLoggedIn;
