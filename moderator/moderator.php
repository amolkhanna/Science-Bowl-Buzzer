<?php
include "../global/database-global.php";

clean_rooms();

$currentCode = "";

/* 
* Finds and assigns the site to an unused room
*/
function get_room()
{
    global $connection;
    global $currentCode;
    $iterations = 0;
    $code = null;
    $date = date("Y-m-d H:i:s");

    for ($iterations = 0; $iterations < 5; $iterations++) {
        $int_a = rand(0, 35);
        $int_b = rand(0, 35);
        $int_c = rand(0, 35);
        $temp_code = number_to_code($int_a) . number_to_code($int_b) . number_to_code($int_c);
        $sql = "SELECT active FROM rooms WHERE code = '$temp_code'";
        $sql_result = mysqli_fetch_array(mysqli_query($connection, $sql))[0];
        if ($sql_result[0] == null) {
            $code = $temp_code;
            break;
        }
    }
    
    if ($code === null) {
        $sql = "SELECT code FROM rooms WHERE active IS NULL ORDER BY code LIMIT 1";
        $code = mysqli_fetch_array(mysqli_query($connection, $sql))[0];
    }

    $sql = "UPDATE rooms SET active = '$date' WHERE code = '$code'";
    mysqli_query($connection, $sql);
    $currentCode = $code;
    return $code;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Science Bowl Moderator</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500" rel="stylesheet">
    <link rel="stylesheet" href="../global/styles-global.css">
    <link rel="stylesheet" href="styles-moderator.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="../global/scripts-global.js"></script>
    <script src="scripts-moderator.js"></script>

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
            <br> <br>This site has been designed for laptop/desktop use in a landscape orientation. We recommend
            using a laptop/desktop in full
            screen.</p>
    </div>
    <div class="Container">
        <div id="Buzzer">
            <div class="Team TeamA TeamLabel" id="TeamALabel">
                <h1 id="TeamALabelText">Code: <?php echo get_room() ?></h1>
            </div>
            <div class="Game" id="GameLabel">
                <h1 id="GameLabelText"><pre>Player:             </pre></h1>
            </div>
            <div class="Team TeamB TeamLabel" id="TeamBLabel">
                <button class="Button" id="ResetBuzzerButton" onclick="resetBuzzer('<?php echo $currentCode ?>');">Reset Buzzer</button>
            </div>
        </div>
        <div id="PointsGameClock">
            <div class="Team TeamA TeamPoints" id="TeamAPoints">
                <div class="TeamPointBox" id="TeamAPointBox">
                    <h1 id="TeamAPointText">000</h1>
                </div>
            </div>
            <div class="Game" id="GameClock">
                <div class="ClockBox" id="GameClockBox">
                    <h1 id="GameClockText">8:00</h1>
                </div>
                <div class="ClockButtons" id="GameClockButtons">
                    <button class="Button GameClockButton" id="StartPause"
                        onclick="startPauseGameClock()">Start/Pause</button>
                    <button class="Button GameClockButton" id="Reset" onclick="resetClock(gameClock)">Reset</button>
                </div>
            </div>
            <div class="Team TeamB TeamPoints" id="TeamBPoints">
                <div class="TeamPointBox" id="TeamBPointBox">
                    <h1 id="TeamBPointText">000</h1>
                </div>
            </div>
        </div>
        <div id="ControlQuestionClock">
            <div class="Team TeamA TeamControls" id="TeamAControls">
                <div class="TeamControlButtonDiv" id="TeamAControlButton">
                    <button class="Button TeamControlButton PButton P4Button" id="TeamAP4Button"
                        onclick="changePoints('A', +4)">+4</button>
                    <button class="Button TeamControlButton PButton P10Button" id="TeamAP10Button"
                        onclick="changePoints('A', +10)">+10</button>
                    <button class="Button TeamControlButton MButton M4Button" id="TeamAM4Button"
                        onclick="changePoints('A', -4)">-4</button>
                    <button class="Button TeamControlButton RButton" id="TeamARButton"
                        onclick="resetPoints('A')">Reset</button>
                    <button class="Button TeamControlButton MButton M10Button" id="TeamAM10Button"
                        onclick="changePoints('A', -10)">-10</button>
                </div>
            </div>
            <div class="Game" id="QuestionClock">
                <div class="ClockBox" id="QuestionClockBox">
                    <h1 id="QuestionClockText">0:00</h1>
                </div>
                <div class="ClockButtons" id="QuestionClockButtons">
                    <button class="Button QuestionClockButton" id="TUQuestionClock"
                        onclick="startQuestionClock(5)">Toss-Up</button>
                    <button class="Button QuestionClockButton" id="BonusQuestionClock"
                        onclick="startQuestionClock(20)">Bonus</button>
                    <button class="Button QuestionClockButton" id="ResetQuestionClock"
                        onclick="resetClock(questionClock)">Reset</button>
                </div>
            </div>
            <div class="Team TeamB TeamControls" id="TeamBControls">
                <div class="TeamControlButtonDiv" id="TeamBControlButton">
                    <button class="Button TeamControlButton PButton P4Button" id="TeamBP4Button"
                        onclick="changePoints('B', +4)">+4</button>
                    <button class="Button TeamControlButton PButton P10Button" id="TeamBP10Button"
                        onclick="changePoints('B', +10)">+10</button>
                    <button class="Button TeamControlButton MButton M4Button" id="TeamBM4Button"
                        onclick="changePoints('B', -4)">-4</button>
                    <button class="Button TeamControlButton RButton" id="TeamBRButton"
                        onclick="resetPoints('B')">Reset</button>
                    <button class="Button TeamControlButton MButton M10Button" id="TeamBM10Button"
                        onclick="changePoints('B', -10)">-10</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>