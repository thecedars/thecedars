import "./PublicPath";

import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import { BrowserRouter } from "react-router-dom";
import { ScrollToTop } from "./components";
import ApolloProvider from "./Apollo";
import AppProvider from "./Context";

ReactDOM.render(
  <React.StrictMode>
    <BrowserRouter>
      <ScrollToTop />
      <ApolloProvider>
        <AppProvider>
          <App />
        </AppProvider>
      </ApolloProvider>
    </BrowserRouter>
  </React.StrictMode>,
  document.getElementById("root")
);
