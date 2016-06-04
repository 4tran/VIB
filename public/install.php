<?php
require("../res/config.php");
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
  $pass = password_hash("admin", PASSWORD_DEFAULT);
  $pass = $db->real_escape_string($pass);
  $db->query("INSERT INTO users (name, password) VALUES
    ('admin',	'$pass')");
  echo "Successfully imported database.";
}
?>
