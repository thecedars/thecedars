const { spawn } = require("child_process");
const fs = require("fs");

const options = {
  cwd: process.cwd(),
  detached: true,
  stdio: "inherit",
};

spawn("mv", ["./build/index.html", "./build/index.php"], options);

fs.readFile("./build/index.php", "utf8", function (err, data) {
  if (err) {
    return console.log(err);
  }

  const result = data.replace(`lang="en"`, "<?php language_attributes(); ?>");

  fs.writeFile("./build/index.php", result, "utf8", function (err) {
    if (err) return console.log(err);
  });
});

spawn("rsync", ["-av", "./theme/", "./build/"], options);

if (process.env.GO_DOCKER) {
  // Copy build and plugins to Docker env.
  spawn(
    "rsync",
    [
      "-av",
      "--delete",
      "./build/",
      `${process.env.HOME}/docker/the-cedars/wp-content/themes/the-cedars/`,
    ],
    options
  );

  spawn(
    "rsync",
    [
      "-av",
      "--delete",
      "./plugins/the-directory/",
      `${process.env.HOME}/docker/the-cedars/wp-content/plugins/the-directory/`,
    ],
    options
  );
}
