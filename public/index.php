<?php
require("../res/config.php");
$db->real_query("SELECT * FROM boards");
$res = $db->use_result();
echo "<div class=\"header\">";
while ($row = $res->fetch_assoc()) {
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a> <p> </p><p> </p>";
}
echo "</div><br/><br/>";
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <?php echo "<title> Home - " . $config['site_name'] . "</title>"; ?>
</head>
<body>
<?php
$boards = array();
$db->real_query("SELECT url FROM boards");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  array_push($boards, $row['url']);
}
echo "<div class=\"recent\">";
echo "<h3 id=\"latest_posts\">Latest Posts</h3><br/>";
foreach ($boards as $x) {
  $x = $db->real_escape_string($x);
  $db->real_query("SELECT * FROM posts_".$x." ORDER BY timestamp DESC LIMIT 1");
  $res = $db->use_result();
  while ($row = $res->fetch_assoc()) {
    echo "<p style=\"font-size:110%;\">/$x/ - </p>" . "<p>" . nl2br($row["content"])
    . "<a href=\"" . "$x/" . $row['op'] . "\"> [reply]</a></p><br/>";
  }
}
echo "</div>";
?>
</body>
</html>
