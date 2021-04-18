import { gql, useMutation } from "@apollo/client";
import { useHistory } from "react-router-dom";
import { useAppContext } from "../Context";

const Mutation = gql`
  mutation LoginMutation(
    $username: String!
    $password: String!
    $clientMutationId: String!
  ) {
    login(
      input: {
        clientMutationId: $clientMutationId
        login: $username
        password: $password
      }
    ) {
      clientMutationId
      status
      viewer {
        id
        databaseId
        capabilities
      }
    }
  }
`;

export function useLogin(props) {
  const { setCapabilities, setViewerId } = useAppContext();
  const { setMessage } = props || {};
  const history = useHistory();

  const [mutate, { loading }] = useMutation(Mutation, {
    onCompleted: function (data) {
      const status = data ? data.login?.status || false : false;
      const capabilities = data ? data.login?.viewer?.capabilities || [] : [];
      const viewerId = data ? data.login?.viewer?.databaseId || 0 : 0;

      setCapabilities(capabilities);
      setViewerId(viewerId);

      if (status === "SUCCESS") {
        if (capabilities.includes("manage_options")) {
          window.location.href = "/wp-admin/index.php";
        } else {
          history.push("/");
        }
      } else if (setMessage) {
        setMessage(status);
      }
    },

    onError: function (data) {
      if (setMessage) {
        setMessage(data.message);
      }
    },
  });

  function login(username, password) {
    const clientMutationId =
      Math.random().toString(36).substring(2) +
      new Date().getTime().toString(36);

    const variables = {
      username,
      password,
      clientMutationId,
    };

    mutate({ variables });
  }

  return { login, loading };
}

export default useLogin;
