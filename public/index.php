<?php
require("../res/config.php");
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
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <?php echo "<title> Home - " . $config['site_name'] . "</title>"; ?>
</head>
<body>
</body>
</html>
