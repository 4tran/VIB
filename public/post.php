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
  if (!file_exists("$url/$id/res")) {
    mkdir("$url/$id/res", 0777, true);
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
<div class="header">
<?php
$target_dir = "$url/$id/res/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$url = $db->real_escape_string($_POST["url"]);
$db->real_query("SELECT id FROM posts_".$url." ORDER BY id DESC LIMIT 1");
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  $id = $row['id'];
}
$id = $db->real_escape_string($id);
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    }
    else {
        echo "<p>File is not an image.</p>";
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    echo "<p>Image already exists. Rename image.</p>";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "<p>Image is too large.</p>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "<p>Only JPG, JPEG, PNG & GIF files are allowed.</p>";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "<p>Your image was not uploaded.</p>";
}
else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "<p>The image ". basename( $_FILES["image"]["name"]). " has been uploaded.</p>";
        $image = $db->real_escape_string($target_file);
        $db->query("UPDATE posts_".$url." SET
        image = '$image'
        WHERE id = '$id'");
    }
    else {
        echo "<p>There was an error uploading your file.</p>";
    }
}
if ($_POST['type'] == "reply") {
  $id = $_POST['id'];
}
?>
<?php echo "<br/><a href=\"/$url/\">Return to the board home.</a></br>";
echo "<a href=\"/$url/$id/\">Return to the thread.</a></div>"; ?>
</body>
</html>
