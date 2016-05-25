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
