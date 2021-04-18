import React from "react";
import { Switch, Route, useLocation } from "react-router-dom";
import { Main } from "./layout";
import { Home } from "./home";
import Header from "./header";
import Footer from "./footer";
import { AuthenticationRouting, LoginPathnames } from "./auth";
import Node from "./node";
import Search from "./search";
import "./scss/app.scss";

export function App() {
  const { search } = useLocation();
  const previewId = new URLSearchParams(search).get("p");

  return (
    <div className="min-vh-100 flex items-stretch flex-column w-100 sans-serif near-black relative z-1">
      <Header />
      <Main>
        <Switch>
          <Route exact path="/">
            {previewId ? <Node databaseId={previewId} /> : <Home />}
          </Route>

          <Route exact path={LoginPathnames}>
            <AuthenticationRouting />
          </Route>

          <Route exact path="/search">
            <Search />
          </Route>

          <Route path="*">
            <Node />
          </Route>
        </Switch>
      </Main>
      <Footer />
    </div>
  );
}

export default App;
