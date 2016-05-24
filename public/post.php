<?php
require("../res/config.php");
$url = $db->real_escape_string($_POST["url"]);
$name = $db->real_escape_string($_POST["name"]);
$content = $db->real_escape_string($_POST["content"]);
$id = 0;

if($_POST['type'] == "thread") {
  $db->real_query("SELECT id FROM posts_".$url." ORDER BY id DESC LIMIT 1");
  $res = $db->use_result();
  while ($row = $res->fetch_assoc()) {
    $id = $row['id'];
  }
  $id++;
  $id = $db->real_escape_string($id);

  $db->query("INSERT INTO posts_".$url." (name, content, op, timestamp)
  VALUES ('$name', '$content', '$id', now())");
  $url = $_POST['url'];

  if (!file_exists("$url/$id")) {
    mkdir("$url/$id", 0777, true);
  }
  copy("../res/temps/thread.php", "$url/$id/index.php");
}
echo "<a href=\"$url\">Click here to go back to the board home.</a>";
?>
