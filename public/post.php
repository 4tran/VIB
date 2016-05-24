<?php
require("../res/config.php");
$url = $db->real_escape_string($_POST["url"]);
$name = $db->real_escape_string($_POST["name"]);
$content = $db->real_escape_string($_POST["content"]);
$db->query("INSERT INTO posts_".$url." (name, content, timestamp)
VALUES ('$name', '$content', now())");
$url = $_POST['url'];
echo "<a href=\"$url\">Click here to go back to the board home.</a>";
?>
