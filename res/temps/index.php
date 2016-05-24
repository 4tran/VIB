<?php
$config = json_decode(file_get_contents("../../config.json"), true);
$db = new mysqli($config['ip'], $config['user'], $config['pass'], $config['db']);
if ($db->connect_errno) {
  echo "Failed to connect to database. Please check config.json";
}
$board_config = json_decode(file_get_contents("config.json"), true);
$url = $db->real_escape_string($board_config['url']);

$db->real_query("SELECT * FROM boards");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a>";
}
echo "<br/><br/>";
?>

<html>
<body>

<?php echo "<title>Home - " . $board_config['name'] . "</title>"; ?>
<form action="../post.php" method="post">
<?php echo "<input type=\"hidden\" name=\"url\" value=\"" . $board_config['url'] . "\">"; ?>
Name: <input type="text" name="name" style="margin-bottom:5px"><br/>
<textarea name="content" rows="5" cols="40" style="margin-bottom:5px"></textarea><br/>
<input type="submit">
</form>

<?php
$db->real_query("SELECT * FROM posts_".$url." ORDER BY id DESC LIMIT 10");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  if($row['id'] == $row['op']) {
    echo "By: " . $row['name'] . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "<br/>";
    echo $row['content'] . "<br/><br/>";
  }
}
?>

</body>
</html>
