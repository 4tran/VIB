<?php
require("../res/config.php");
$db->real_query("SELECT * FROM users");
$users = array();
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  array_push($users, [$row['name'], $row['password']]);
}
if (($users[0][0] == $_POST["user"]) && ($users[0][1] == $_POST["pass"])) {
  $url = $db->real_escape_string($_POST["url"]);
  $name = $db->real_escape_string($_POST["name"]);
  $db->query("INSERT INTO boards (url, board_name) VALUES
    ('$url', '$name') WHERE NOT EXISTS (
    SELECT url FROM table_listnames WHERE url = '$url'
  )");

  $db->query("DROP TABLE IF EXISTS posts_".$url."");
  $db->query("CREATE TABLE posts_".$url." (
    id int(11) NOT NULL AUTO_INCREMENT,
    name text NOT NULL,
    content text NOT NULL,
    timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
  )");
  $url = $_POST["url"];
  if (!file_exists("$url")) {
    mkdir("$url", 0777, true);
  }
  $b_conf = fopen("$url/config.json", "w");
  $txt = "{\n";
  fwrite($b_conf, $txt);
  $txt = '    "url": "' . $url . '",' . "\n";
  fwrite($b_conf, $txt);
  $txt = '    "name": "' . $_POST['name'] . '"' . "\n";
  fwrite($b_conf, $txt);
  $txt = "}\n";
  fwrite($b_conf, $txt);
  fclose($b_conf);
  copy("../res/temps/index.php", "$url/index.php");
  echo "Board succesfully created or wiped.";
}
else {
  echo "Incorrect username or password.";
}
?>
