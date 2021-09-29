const { execSync } = require("child_process");
const fs = require("fs");
const path = require("path");

fs.rename(
  path.join("build", "index.html"),
  path.join("build", "index.php"),
  function () {
    fs.readFile(path.join("build", "index.php"), "utf8", function (err, data) {
      if (err) {
        return console.log(err);
      }

      let result = data.replace(`lang="en"`, "<?php language_attributes(); ?>");

      result = result.replace(
        new RegExp("/wp-content", "g"),
        "<?php echo get_site_url( null ); ?>/wp-content"
      );

      fs.writeFile(
        path.join("build", "index.php"),
        result,
        "utf8",
        function (err) {
          if (err) return console.log(err);
        }
      );
    });
  }
);

execSync("rsync -av ./theme/ ./build/");
