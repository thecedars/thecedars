import { gql, useQuery } from "@apollo/client";

export function useMenu(props) {
  const { location = "HEADER_MENU", parentId = 0, ...rest } = props || {};
  const variables = { location, parentId };

  const { data, loading, error } = useQuery(Query, {
    variables,
    errorPolicy: "all",
    ...rest,
  });

  const menuItems = data?.menuItems?.nodes || [];

  return { menuItems, loading, error };
}

const FragmentMenuItem = `
  fragment MenuItemFragment on MenuItem {
    id
    databaseId
    parentId
    url
    label
    cssClasses
    connectedNode {
      node {
        __typename
      }
    }
  }
`;

const FragmentMenuItemLevel3 = `
  fragment MenuItemLevel3Fragment on MenuItem {
    childItems(first:25) {
      nodes {
        ...MenuItemFragment
      }
    }
  }
`;

const FragmentMenuItemLevel2 = `
  fragment MenuItemLevel2Fragment on MenuItem {
    childItems(first: 50) {
      nodes {
        ...MenuItemFragment
        ...MenuItemLevel3Fragment
      }
    }
  }
`;

const Query = gql`
  query MenuHook($location: MenuLocationEnum!, $parentId: ID!) {
    menuItems(first: 100, where: { location: $location, parentId: $parentId }) {
      nodes {
        ...MenuItemFragment
        ...MenuItemLevel2Fragment
      }
    }
  }
  ${FragmentMenuItem}
  ${FragmentMenuItemLevel2}
  ${FragmentMenuItemLevel3}
`;

export default useMenu;
