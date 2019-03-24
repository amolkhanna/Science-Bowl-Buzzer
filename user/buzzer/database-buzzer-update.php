<?php
include "../../global/database-global.php";

$postedUser = $_POST["user"];
$postedCode = $_POST["code"];
$postedDatetime = date("Y-m-d H:i:s");

$sqlRoom = "SELECT active FROM rooms WHERE code = '$postedCode'";

if (mysqli_fetch_array(mysqli_query($connection, $sqlRoom))[0] != null) {
    $sqlUser = "SELECT user FROM rooms WHERE code = '$postedCode'";
    if (mysqli_fetch_array(mysqli_query($connection, $sqlUser))[0] == null) {
        $sqlUpdate = "UPDATE rooms SET user = '$postedUser', buzztime = '$postedDatetime' WHERE code = '$postedCode'";
        mysqli_query($connection, $sqlUpdate);
    }
} else {
    unset($_SESSION["user"]);
    unset($_SESSION["code"]);
}
