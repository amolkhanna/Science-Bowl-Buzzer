<?php
include "../global/database-global.php";

$code = $_POST["code"];

$sqlUpdate = "UPDATE rooms SET user = NULL WHERE code = '$code'";
mysqli_query($connection, $sqlUpdate);
?>