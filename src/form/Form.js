import React from "react";
import { Button } from "../components";
import { gql } from "@apollo/client";
import Field from "./Field";
import Input from "./Input";
import Recaptcha from "./Recaptcha";
import Textarea from "./Textarea";
import useForm from "./useForm";
import Valid from "./Valid";
import Select from "./Select";

const FormMutation = gql`
  mutation FormMutation($input: DefaultFormMutationInput!) {
    defaultFormMutation(input: $input) {
      success
      errorMessage
      clientMutationId
    }
  }
`;

export function Form({ className }) {
  const { fields, token, onClick, error, success, loading } = useForm({
    mutation: FormMutation,
  });

  return (
    <div {...{ className }}>
      <div>
        {error && <div className="bg-near-white f4 red pa3 mb3">{error}</div>}
        {success && (
          <div className="bg-near-white f4 green pa3 mb3">{success}</div>
        )}
      </div>
      <div>
        <Field id="yourName" label="Name" required>
          <Input
            ref={fields}
            errorMessage="Provide a name."
            valid={Valid.NotEmptyString}
          />
        </Field>
        <div className="flex-l">
          <Field id="email" label="Email" required className="w-50-l pr2-l">
            <Input
              ref={fields}
              type="email"
              errorMessage="Must be an email."
              valid={Valid.Email}
            >
              <Recaptcha {...{ token }} />
            </Input>
          </Field>
          <Field id="phone" label="Phone" className="w-50-l pl2-l">
            <Input ref={fields} type="tel" />
          </Field>
        </div>
        <Field id="inquiry" label="Nature of Inquiry">
          <Select ref={fields} type="select">
            <option value="General">General Inquiry</option>
            <option value="Title Company">Title Company</option>
            <option value="Directory Update">
              Update your directory information
            </option>
          </Select>
        </Field>
        <Field id="message" label="Message" required>
          <Textarea
            ref={fields}
            errorMessage="State the nature of your inquiry."
            valid={Valid.NotEmptyString}
          />
        </Field>

        <div className="tc mt3">
          <Button {...{ onClick, loading }} form>
            Submit
          </Button>
        </div>
      </div>
    </div>
  );
}

export default Form;
