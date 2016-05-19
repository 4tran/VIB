<?php
require("../res/config.php");
if (!$db->connect_errno) {
  $db->query("DROP TABLE IF EXISTS boards");
  $db->query("CREATE TABLE boards (
    url text NOT NULL,
    board_name text NOT NULL,
    post_count int(11) NOT NULL
  )");
  $db->query("INSERT INTO boards (url, board_name, post_count) VALUES
  ('test', 'test', 1)");

  $db->query("DROP TABLE IF EXISTS posts");
  $db->query("CREATE TABLE posts (
    id int(11) NOT NULL,
    board_url text NOT NULL,
    name text NOT NULL,
    content text NOT NULL
  )");
  $db->query("INSERT INTO posts (id, board_url, name, content) VALUES
  (1,	'test',	'Test',	'Test post.')");

  $db->query("DROP TABLE IF EXISTS users");
  $db->query("CREATE TABLE users (
    name text NOT NULL,
    password text NOT NULL
  )");
  $db->query("INSERT INTO users (name, password) VALUES
  ('admin',	'admin')");
  echo "Succesfully imported database.";
}
?>
