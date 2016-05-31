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
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a> <p> </p><p> </p>";
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
<form action="../post.php" method="post" enctype="multipart/form-data">
<?php echo "<input type=\"hidden\" name=\"url\" value=\"" . $board_config['url'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"type\" value=\"thread\">"; ?>
<p>Name: </p><input type="text" name="name" style="margin-bottom:5px"><br/>
<textarea name="content" rows="5" cols="40" style="margin-bottom:5px"></textarea><br/>
<input type="file" name="image" id="image"><br/>
<input type="submit" value="Post">
</form>
</div>

<?php
$url = $board_config['url'];
$db->real_query("SELECT * FROM posts_".$url." ORDER BY id DESC");
$res = $db->use_result();
$posts = array();
while ($row = $res->fetch_assoc()) {
  $posts[] = $row;
}
for ($i = 0; $i < count($posts); $i++) {
  if ($posts[$i]['id'] == $posts[$i]['op']) {
    $op = $db->real_escape_string($posts[$i]['op']);
    echo "<div class=\"op\">";
    if ($posts[$i]['name'] == "" && $posts[$i]['image'] != "") {
      echo "<p class=\"info\">By: Anonymous. Created: " . $posts[$i]['timestamp'] . " ID: " . $posts[$i]['id'] . "<a href=\"" . $posts[$i]['id'] . "\"> [reply]</a></p><br/>";
      echo "<div class=\"image\"><img src=\"/" . $posts[$i]['image'] . "\" id=\"" . $posts[$i]['id'] . "\" onclick=\"resize(" . $posts[$i]['id'] . ")\" alt=\"Full Size\"></div>";
    }
    else if ($posts[$i]['name'] != "" && $posts[$i]['image'] == "") {
      echo "<p class=\"info\" id=\"" . $posts[$i]['id'] . "\">By: " . htmlspecialchars($posts[$i]['name']) . ". Created: " . $posts[$i]['timestamp'] . " ID: " . $posts[$i]['id'] . "<a href=\"" . $posts[$i]['id'] . "\"> [reply]</a></p><br/>";
    }
    else if ($posts[$i]['name'] != "" && $posts[$i]['image'] != "") {
      echo "<p class=\"info\">By: " . htmlspecialchars($posts[$i]['name']) . ". Created: " . $posts[$i]['timestamp'] . " ID: " . $posts[$i]['id'] . "<a href=\"" . $posts[$i]['id'] . "\"> [reply]</a></p><br/>";
      echo "<div class=\"image\"><img src=\"/" . $posts[$i]['image'] . "\" id=\"" . $posts[$i]['id'] . "\" onclick=\"resize(" . $posts[$i]['id'] . ")\" alt=\"Full Size\"></div>";
    }
    else if ($posts[$i]['name'] == "" && $posts[$i]['image'] == "") {
      echo "<p class=\"info\" id=\"" . $posts[$i]['id'] . "\">By: Anonymous. Created: " . $posts[$i]['timestamp'] . " ID: " . $posts[$i]['id'] . "<a href=\"" . $posts[$i]['id'] . "\"> [reply]</a></p><br/>";
    }
    echo "<p>" . nl2br($posts[$i]['content']) . "</p><br/><br/>";
    echo "</div>";
    $db->real_query("SELECT * FROM posts_".$url." WHERE op = '$op' ORDER BY id DESC LIMIT 3");
    $res = $db->use_result();
    while ($row = $res->fetch_assoc()) {
      if ($row['id'] != $op) {
        echo "<div class=\"reply\">";
        if ($row['name'] == "" && $row['image'] != "") {
          echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
          echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row['id'] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
        }
        else if ($row['name'] != "" && $row['image'] == "") {
          echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        }
        else if ($row['name'] != "" && $row['image'] != "") {
          echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
          echo "<div class=\"image\"><img src=\"/" . $row['image'] . "\" id=\"" . $row['id'] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
        }
        else if ($row['name'] == "" && $row['image'] == "") {
          echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: Anonymous. Created: " . $row['timestamp'] . " ID: " . $row['id'] . "</p><br/>";
        }
        echo "<p>" . nl2br($row['content']) . "</p><br/><br/>";
        echo "</div>";
      }
    }
  }
}

?>
<script type="text/javascript" src="/js/image-resize.js"></script>
<script type="text/javascript" src="/js/quote.js"></script>
</body>
</html>
