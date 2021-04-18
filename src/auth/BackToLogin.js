import React from "react";
import { Link } from "react-router-dom";

export function BackToLogin() {
  return (
    <Link to="/login" className="db mt3 tc tr-l mt3 no-underline primary">
      &lt; Back to Login
    </Link>
  );
}

export default BackToLogin;
