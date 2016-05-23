<?php
require("../res/config.php");
$db->real_query("SELECT * FROM users");
$users = array();
$res = $db->use_result();
while ($row = $res->fetch_assoc()) {
  array_push($users, [$row['name'], $row['password']]);
}
if (($users[0][0] == $_POST["user"]) && ($users[0][1] == $_POST["pass"])) {
  if (!$db->connect_errno) {
    $db->query("DROP TABLE IF EXISTS boards");
    $db->query("CREATE TABLE boards (
      url text NOT NULL,
      board_name text NOT NULL,
      post_count int(11) NOT NULL
    )");
    $db->query("INSERT INTO boards (url, board_name, post_count) VALUES
      ('test', 'test', 1)");

    $db->query("DROP TABLE IF EXISTS posts_test");
    $db->query("CREATE TABLE posts_test (
      id int(11) NOT NULL AUTO_INCREMENT,
      name text NOT NULL,
      content text NOT NULL,
      timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (id)
    )");
    $db->query("INSERT INTO posts_test (id, name, content, timestamp) VALUES
      (1,	'Anonymous',	'Test post.',	'2016-05-23 14:02:07')");

    $db->query("DROP TABLE IF EXISTS users");
    $db->query("CREATE TABLE users (
      name text NOT NULL,
      password text NOT NULL
    )");
    $db->query("INSERT INTO users (name, password) VALUES
      ('admin',	'admin')");
    echo "Succesfully imported database.";
  }
}
?>
