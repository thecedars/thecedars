import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import { BrowserRouter } from "react-router-dom";
import { ScrollToTop } from "./components";
import ApolloProvider from "./Apollo";
import AppProvider from "./Context";

ReactDOM.render(
  <BrowserRouter>
    <ScrollToTop />
    <ApolloProvider>
      <AppProvider>
        <App />
      </AppProvider>
    </ApolloProvider>
  </BrowserRouter>,
  document.getElementById("root")
);
