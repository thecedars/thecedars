export const Valid = {
  NotEmptyString: (v) => (v || "") !== "",
  Email: (v) => /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(v || ""),
  Phone: (v) =>
    /^(1[ \-+]{0,3}|\+1[ -+]{0,3}|\+1|\+)?((\(\+?1-[2-9][0-9]{1,2}\))|(\(\+?[2-8][0-9][0-9]\))|(\(\+?[1-9][0-9]\))|(\(\+?[17]\))|(\([2-9][2-9]\))|([ \-.]{0,3}[0-9]{2,4}))?([ \-.][0-9])?([ \-.]{0,3}[0-9]{2,4}){2,3}$/im.test(
      v || ""
    ),
  LessThan: (amount) => {
    return (v) => {
      return (v || "").length < amount;
    };
  },
  GreaterThan: (amount) => {
    return (v) => {
      return (v || "").length > amount;
    };
  },
  MinWords: (amount) => {
    return (v) => {
      return (v || "").replace(/\s\s+/g, " ").split(" ").length > amount - 1;
    };
  },
};

export default Valid;
