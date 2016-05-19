<?php
require("../res/config.php");
$db->real_query("SELECT * FROM posts ORDER BY id ASC");
$res = $db->use_result();
echo "<head><title> Home - " . $config['site_name'] . "</title></head>";
echo "Here's the latest post: <br/>";
while ($row = $res->fetch_assoc()) {
  echo "#" . $row['id'] . ": " . $row['content'] . "<br/>";
}
?>
