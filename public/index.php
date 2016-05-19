<?php
require("../res/config.php");
$db->real_query("SELECT * FROM posts ORDER BY id DESC LIMIT 5");
$res = $db->use_result();
echo "<head><title> Home - " . $config['site_name'] . "</title></head>";
echo "Here's the latest posts: <br/>";
while ($row = $res->fetch_assoc()) {
  echo "#" . $row['id'] . ": " . $row['content'] . "<br/>";
}
?>
