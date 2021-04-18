import { gql, useQuery } from "@apollo/client";

const SettingsQuery = gql`
  query SettingsQuery {
    allSettings {
      title: generalSettingsTitle
      description: generalSettingsDescription
    }
    themeMods {
      logo: customLogoSrc
    }
  }
`;

export function useSettings() {
  const { data, loading, error } = useQuery(SettingsQuery, {
    errorPolicy: "all",
  });

  const themeMods = data?.themeMods || {};
  const allSettings = data?.allSettings || {};

  return {
    ...allSettings,
    ...themeMods,
    loading,
    error,
  };
}

export default useSettings;
