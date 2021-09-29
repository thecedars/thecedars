import React from "react";
import {
  ApolloClient,
  ApolloProvider as Provider,
  InMemoryCache,
  HttpLink,
  ApolloLink,
  from,
} from "@apollo/client";
import { relayStylePagination } from "@apollo/client/utilities";

const monthNames = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];

const relay = relayStylePagination();

const cache = new InMemoryCache({
  typePolicies: {
    Query: {
      fields: {
        contentNodes: {
          ...relay,
          keyArgs: function (args) {
            if (args.where.search) {
              return ["where"];
            }

            return false;
          },
        },
        posts: relay,
      },
    },
    User: {
      fields: {
        posts: relay,
      },
    },
    Category: {
      fields: {
        posts: relay,
      },
    },
    Tag: {
      fields: {
        posts: relay,
      },
    },
    ContentType: {
      fields: {
        contentNodes: relay,
        graphqlPluralName: {
          read: function (data) {
            if (data) {
              return data.charAt(0).toUpperCase() + data.slice(1);
            }

            return data;
          },
        },
      },
    },
    Post: {
      fields: {
        date: {
          read: function (date) {
            const d = new Date(date);

            return `${
              monthNames[d.getMonth()]
            } ${d.getDate()}, ${d.getFullYear()}`;
          },
        },
      },
    },
  },
});

const authAfterware = new ApolloLink((operation, forward) => {
  return forward(operation).map((response) => {
    // If we get an error, log the error.
    if (response?.errors?.length > 0) {
      console.error(response.errors);
    }

    return response;
  });
});

const link = new HttpLink({
  uri: window.__WP.GQLURL,
});

export function ApolloProvider({ children }) {
  const client = new ApolloClient({
    link: from([authAfterware, link]),
    cache,
  });

  return <Provider {...{ client }}>{children}</Provider>;
}

export default ApolloProvider;
