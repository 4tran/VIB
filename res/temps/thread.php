<?php
$config = json_decode(file_get_contents("../../../config.json"), true);
$db = new mysqli($config['ip'], $config['user'], $config['pass'], $config['db']);
if ($db->connect_errno) {
  echo "Failed to connect to database. Please check config.json";
}
$board_config = json_decode(file_get_contents("../config.json"), true);
$thread = json_decode(file_get_contents("thread.json"), true);
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
  <?php echo "<title>/" . $board_config['url'] . "/</title>"; ?>
  <script>
  var big = 0;
  function resize(id) {
    if (big == 0) {
      document.getElementById(id).style.height = "initial";
      big = 1;
    }
    else {
      document.getElementById(id).style.height = "150px";
      big = 0;
    }
  }
  </script>
</head>
<body>

<div class="post">
<form action="../../post.php" method="post" enctype="multipart/form-data">
<?php echo "<input type=\"hidden\" name=\"url\" value=\"" . $board_config['url'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"id\" value=\"" . $thread['id'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"type\" value=\"reply\">"; ?>
<p>Name: </p><input type="text" name="name" style="margin-bottom:5px"><br/>
<textarea name="content" rows="5" cols="40" style="margin-bottom:5px"></textarea><br/>
<input type="file" name="image" id="image"><br/>
<input type="submit" value="Reply">
</form>
</div>

<?php
$db->real_query("SELECT * FROM posts_".$url." ORDER BY id ASC");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  if($row['op'] == $thread['id']) {
    if ($row['id'] == $row['op']) {
      echo "<div class=\"op\">";
      if ($row['name'] == "" && $row['image'] != "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row[id] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] != "" && $row['image'] == "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
      }
      else if ($row['name'] != "" && $row['image'] != "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row[id] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] == "" && $row['image'] == "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
      }
      echo "<p>" . htmlspecialchars($row['content']) . "</p><br/><br/>";
      echo "</div>";
    }
    else {
      echo "<div class=\"reply\">";
      if ($row['name'] == "" && $row['image'] != "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row[id] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] != "" && $row['image'] == "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
      }
      else if ($row['name'] != "" && $row['image'] != "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row[id] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] == "" && $row['image'] == "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
      }
      echo "<p>" . htmlspecialchars($row['content']) . "</p><br/><br/>";
      echo "</div>";
    }
  }
}
?>

</body>
</html>
