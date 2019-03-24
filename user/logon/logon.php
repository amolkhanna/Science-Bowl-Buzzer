<?php
include "../../global/database-global.php";

$user = "";
$code = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = substr(test_input($_POST["user"]), 0, 12);
    $code = test_input($_POST["code"]);
    $sql = "SELECT active FROM rooms WHERE code = '$code'";
    $sql_result = mysqli_fetch_array(mysqli_query($connection, $sql))[0];
    if ($sql_result[0] == null) {
        header("location: logon.php");
    } else {
        $_SESSION["user"] = $user;
        $_SESSION["code"] = $code;
        header("location: ../buzzer/buzzer.php");
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strtoupper($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Buzzer</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500" rel="stylesheet">
    <link rel="stylesheet" href="../../global/styles-global.css">
    <link rel="stylesheet" href="styles-logon.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../../global/scripts-global.js"></script>

    <meta charset="UTF-8">
    <meta name="description" content="Wireless Science Bowl Buzzer">
    <meta name="keywords" content="Science Bowl Buzzer">
    <meta name="author" content="NHSS Science Bowl">
    <meta name="viewport" content="width = device-width, initial-scale = 1.0">
</head>

<body>
    <div class="ScreenNotSupported">
        <h1>We Are Sorry...</h1>
        <p>but we currently do not support your current screen resolution.
            <br> <br>This site has been designed for phone use in a portrait orientation and laptop/desktop use in a
            landscape orientation. We recommend
            using a laptop/desktop in full
            screen.</p>
    </div>
    <div class="Container">
        <div id="Logon">
            <form id="LogonForm" autocomplete="off" method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="LogonField LogonTextField" id="NameText">
                    <p>Name:</p>
                </div>
                <div class="LogonField LogonInputField" id="NameInput">
                    <input type="text" name="user">
                </div>
                <div class="LogonField LogonTextField" id="CodeText">
                    <p>Code:</p>
                </div>
                <div class="LogonField LogonInputField" id="CodeInput">
                    <input type="text" name="code">
                </div>
                <div class="LogonField SubmitField" id="LogonSubmit">
                    <input class="Button" id="SubmitButton" type="submit" name="submit" value="Enter Game!">
                </div>
            </form>
        </div>
    </div>
</body>

</html>