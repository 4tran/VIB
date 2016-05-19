<?php
$config = json_decode(file_get_contents("../config.json"), true);
$db = new mysqli($config['ip'], $config['user'], $config['pass'], $config['db']);
if ($db->connect_errno) {
  echo "Failed to connect to database. Please check config.json";
}
?>
