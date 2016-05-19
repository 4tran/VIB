<?php
require("../res/config.php");
$db->real_query("SELECT * FROM fruits ORDER BY id ASC");
$res = $db->use_result();
echo "<head><title> Home - " . $config['site_name'] . "</title></head>";
echo "Here's a list of my favorite fruits: <br/>";
while ($row = $res->fetch_assoc()) {
    echo "#" . $row['id'] . ": " . $row['fruit'] . "<br/>";
}
?>
