<?php
include "../../global/database-global.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Science Bowl Buzzer</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500" rel="stylesheet">
    <link rel="stylesheet" href="../../global/styles-global.css">
    <link rel="stylesheet" href="styles-buzzer.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../../global/scripts-global.js"></script>
    <script src="scripts-buzzer.js"></script>

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
        <button class="Button" id="BuzzButton" onclick="updateServer('<?php echo $_SESSION['user'] ?>', '<?php echo $_SESSION['code'] ?>');">Buzz!</button>
    </div>
</body>

</html>