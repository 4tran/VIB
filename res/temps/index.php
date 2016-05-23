<?php
$board_config = json_decode(file_get_contents("config.json"), true);
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
</body>
</html>
