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
  $t_json = fopen("$url/$id/thread.json", "w");
  $txt = "{\n";
  fwrite($t_json, $txt);
  $txt = '    "id": "' . $id . '"' . "\n";
  fwrite($t_json, $txt);
  $txt = "}\n";
  fwrite($t_json, $txt);
  fclose($b_conf);
  copy("../res/temps/thread.php", "$url/$id/index.php");
}
else if ($_POST['type'] == "reply") {
  $id = $db->real_escape_string($_POST["id"]);
  $db->query("INSERT INTO posts_".$url." (name, content, op, timestamp)
  VALUES ('$name', '$content', '$id', now())");
}
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="style/main.css">
</head>
<body>
<?php echo "<div class=\"header\"><a href=\"$url\">Return to the board home.</a></br>";
echo "<a href=\"$url/$id\">Return to the thread.</a></div>"; ?>
</body>
</html>
