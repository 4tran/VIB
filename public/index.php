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
$db->real_query("SELECT DISTINCT TABLE_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE COLUMN_NAME IN ('id')
        AND TABLE_SCHEMA='vib'");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  $boards[] = $row;
}
$query = "SELECT * FROM " . $boards[0]["TABLE_NAME"];
for ($i = 1; $i < count($boards); $i++) {
  $query = $query . " UNION SELECT * FROM " . $boards[$i]["TABLE_NAME"];
}
$query = $query . " ORDER BY timestamp DESC LIMIT 10";
echo "<div class=\"recent\">";
echo "<h3 id=\"latest_posts\">Latest Posts</h3><br/>";
$db->real_query($query);
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  echo "<p style=\"font-size:110%;\">/" . $row['board'] . "/ - </p>" . "<p>" . $row["content"]
    . "<a href=\"" . $row['board'] . "/" . $row['op'] . "\"> [reply]</a></p><br/>";
}
echo "</div>";
?>
</body>
</html>
