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
echo "<div class=\"header\">";
while ($row = $res->fetch_assoc()) {
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a>";
}
echo "</div><br/><br/>";
?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="/style/main.css">
  <?php echo "<title>Home - " . $board_config['name'] . "</title>"; ?>
</head>
<body>

<div class="post">
<form action="../post.php" method="post">
<?php echo "<input type=\"hidden\" name=\"url\" value=\"" . $board_config['url'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"type\" value=\"thread\">"; ?>
<p>Name: </p><input type="text" name="name" style="margin-bottom:5px"><br/>
<textarea name="content" rows="5" cols="40" style="margin-bottom:5px"></textarea><br/>
<input type="file" name="image" value="Choose Image"></br>
<input type="submit" value="Post">
</form>
</div>

<?php
$db->real_query("SELECT * FROM posts_".$url." ORDER BY id DESC LIMIT 10");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  if($row['id'] == $row['op']) {
    echo "<div class=\"op\">";
    echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "<a href=\"" . $row['id'] . "\"> [reply]</a>" . "</p><br/>";
    echo "<p>" . htmlspecialchars($row['content']) . "</p><br/><br/>";
    echo "</div>";
  }
}
?>

</body>
</html>
