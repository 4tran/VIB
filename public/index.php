<?php
require("../res/config.php");
$db->real_query("SELECT * FROM boards");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a>";
}
echo "<br/><br/>";
$db->real_query("SELECT id, content, board_url FROM posts ORDER BY id DESC LIMIT 5");
$res = $db->use_result();
echo "<head><title> Home - " . $config['site_name'] . "</title></head>";
echo "Here's the latest posts: <br/>";
while ($row = $res->fetch_assoc()) {
  echo "#" . $row['id'] . ": " . $row['content'] . "<br/>";
}
?>
