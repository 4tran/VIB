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
  echo "<a href=\"/" . $row['url'] . "/\">" . "[" . $row['url'] . "]" .  "</a> <p> </p><p> </p>";
}
echo "</div><br/><br/>";
$id = $db->real_escape_string($thread['id']);
$db->real_query("SELECT content FROM posts_".$url." WHERE id = '$id'");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  $title = $row['content'];
}
?>

<html>
<head>
  <link rel="stylesheet" type="text/css" href="/style/main.css">
  <?php echo "<title>" . $title . "</title>"; ?>
</head>
<body>

<div class="post">
<form action="../../post.php" method="post" enctype="multipart/form-data">
<?php echo "<input type=\"hidden\" name=\"url\" value=\"" . $board_config['url'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"id\" value=\"" . $thread['id'] . "\">"; ?>
<?php echo "<input type=\"hidden\" name=\"type\" value=\"reply\">"; ?>
<label for="name">Name: </label><input type="text" name="name" id="name"><br/>
<textarea name="content" id="content" rows="5" cols="40" style="margin-bottom:5px"></textarea><br/>
<input type="file" name="image" id="image"><br/>
<input type="submit" value="Reply">
</form>
</div>

<?php
$url = $board_config['url'];
$db->real_query("SELECT * FROM posts_".$url." ORDER BY id ASC");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  if($row['op'] == $thread['id']) {
    if ($row['id'] == $row['op']) {
      echo "<div class=\"op\">";
      if ($row['name'] == "" && $row['image'] != "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp']
        . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">" . $row['id']
        . "</a>" . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['thumb'] . "\" id=\""
        . $row['id'] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] != "" && $row['image'] == "") {
        echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: " . htmlspecialchars($row['name'])
        . ". Created: " . $row['timestamp'] . " ID: " . "<a href=\"javascript:quote('>>"
        . $row['id'] . "')\">" . $row['id'] . "</a>" . "</p><br/>";
      }
      else if ($row['name'] != "" && $row['image'] != "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: "

        . $row['timestamp'] . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">"
        . $row['id'] . "</a>" . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['thumb'] . "\" id=\"" . $row['id']
        . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] == "" && $row['image'] == "") {
        echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: Anonymous. Created: "
        . $row['timestamp'] . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">"
        . $row['id'] . "</a>" . "</p><br/>";
      }
      echo "<p>" . nl2br($row['content']) . "</p>";
      echo "</div>";
    }
    else {
      echo "<div class=\"reply\">";
      if ($row['name'] == "" && $row['image'] != "") {
        echo "<p class=\"info\">By: Anonymous. Created: " . $row['timestamp']
        . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">" . $row['id']
        . "</a>" . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['thumb'] . "\" id=\""
        . $row['id'] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] != "" && $row['image'] == "") {
        echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: "
        . htmlspecialchars($row['name']) . ". Created: " . $row['timestamp']
        . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">" . $row['id'] . "</a>"
        . "</p><br/>";
      }
      else if ($row['name'] != "" && $row['image'] != "") {
        echo "<p class=\"info\">By: " . htmlspecialchars($row['name']) . ". Created: "
        . $row['timestamp'] . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">"
        . $row['id'] . "</a>" . "</p><br/>";
        echo "<div class=\"image\"><img src=\"/" . $row['thumb'] . "\" id=\""
        . $row['id'] . "\" onclick=\"resize(" . $row['id'] . ")\" alt=\"Full Size\"></div>";
      }
      else if ($row['name'] == "" && $row['image'] == "") {
        echo "<p class=\"info\" id=\"" . $row['id'] . "\">By: Anonymous. Created: "
        . $row['timestamp'] . " ID: " . "<a href=\"javascript:quote('>>" . $row['id'] . "')\">"
        . $row['id'] . "</a>" . "</p><br/>";
      }
      echo "<p>" . nl2br($row['content']) . "</p>";
      echo "</div>";
    }
  }
}
?>
<script type="text/javascript" src="/js/image-resize.js"></script>
<script type="text/javascript" src="/js/quote.js"></script>
</body>
</html>
