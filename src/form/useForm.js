import { useMutation } from "@apollo/client";
import { useRef, useState } from "react";

export function useForm({
  mutation,
  form,
  formError,
  onCompleted,
  onError,
  onFailed,
}) {
  const [success, setSuccess] = useState();
  const [error, setError] = useState();
  const fields = useRef({});
  const token = useRef();

  const [mutate, { loading }] = useMutation(mutation, {
    onCompleted: (data) => {
      const result = Object.values(data)[0];
      if (result.success) {
        setSuccess("Thank you for your submission.");
        setError(false);
      } else {
        setSuccess(false);
        setError(
          result?.errorMessage || "There was an error during submission."
        );
      }

      if (onCompleted) {
        onCompleted(data);
      }
    },
    onError: (error) => {
      setSuccess(false);
      setError(error?.message || "There was an error during submission.");

      if (onError) {
        onError(error);
      }
    },
  });

  const onClick = () => {
    let pass = true;
    Object.values(fields.current).forEach((field) => {
      if (field.error) {
        field.setError(true);
        pass = false;
      }
    });

    if (formError) {
      pass = false;
    }

    if (pass) {
      setError(null);

      const input = {
        clientMutationId: `${new Date().getTime()}`,
      };

      Object.values(fields.current).forEach((field) => {
        input[field.id] = field.value;
      });

      if (form) {
        Object.entries(form).forEach(([k, v]) => {
          input[k] = v;
        });
      }

      if (token.current?.get) {
        token.current
          .get()
          .then((gToken) => {
            mutate({
              variables: {
                input: { ...input, gToken },
              },
            });
          })
          .catch((e) => {
            console.error(e);

            setError("Please refresh the page and try again.");
            if (onError) {
              onError({ pass: false, recaptcha: false });
            }
          });
      } else {
        mutate({
          variables: {
            input,
          },
        });
      }
    } else {
      setSuccess(false);
      setError(formError || "Please check the required fields.");

      if (onFailed) {
        onFailed();
      }
    }
  };

  return {
    fields,
    token,
    loading,
    error,
    success,
    onClick,
  };
}

export default useForm;
