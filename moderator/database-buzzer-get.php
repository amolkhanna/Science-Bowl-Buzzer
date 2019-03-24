<?php
include "../global/database-global.php";

$code = $_POST["code"];

$sql = "SELECT user FROM rooms WHERE code = '$code'";
echo mysqli_fetch_array(mysqli_query($connection, $sql))[0];
?>