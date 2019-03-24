<?php
session_start();
date_default_timezone_set("America/New_York");

/*
* Information to log into server is hidden
*/
$servername = "********";
$username = "********";
$password = "********";
$db = "********";

$connection = mysqli_connect($servername, $username, $password, $db);

/*
 * Converts numbers in for loops to letters and numbers when creating database
 */
function number_to_code($number)
{
    $alphabet = range("A", "Z");
    if ($number < 26) {
        return $alphabet[$number];
    } else {
        return $number - 26;
    }
}

/*
 * Erases any existing database and creates a new one
 */
function create_rooms()
{
    ini_set('max_execution_time', 0);
    global $connection;
    $sql_delete_table = "TRUNCATE TABLE rooms";
    mysqli_query($connection, $sql_delete_table);
    for ($i = 0; $i < 36; $i++) {
        for ($j = 0; $j < 36; $j++) {
            for ($k = 0; $k < 36; $k++) {
                $code_value = number_to_code($i) . number_to_code($j) . number_to_code($k);
                $sql_add_row = "INSERT INTO rooms (code) VALUES ('$code_value')";
                mysqli_query($connection, $sql_add_row);
            }
        }
    }

}

/*
 * Runs whenever moderators try to create a new room: cleans any rooms that are over 2 hours old
 */
function clean_rooms()
{
    global $connection;
    $sql = "SELECT code, active, buzztime FROM rooms WHERE active IS NOT NULL";
    $result = mysqli_query($connection, $sql);
    $date = date("Y-m-d H:i:s");

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $times = array();
            array_push($times, $row["active"], $row["buzztime"]);
            rsort($times);
            if (strtotime($date) - strtotime($times[0]) > 7200) {
                $update_sql = "UPDATE rooms SET active = NULL, user = NULL, buzztime = NULL WHERE code = '" . $row['code'] . "'";
                mysqli_query($connection, $update_sql);
            }
        }
    }

}

?>