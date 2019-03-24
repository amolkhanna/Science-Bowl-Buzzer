/*
* Objects
*/
var teamA = {
    points: 0,
    textID: "#TeamAPointText"
};
var teamB = {
    points: 0,
    textID: "#TeamBPointText"
};

var gameClock = {
    counter: 480,
    interval: null,
    textID: "#GameClockText",
    divID: "#GameClockBox"
};
var questionClock = {
    counter: 0,
    interval: null,
    textID: "#QuestionClockText",
    divID: "#QuestionClockBox"
};

/*
* Helper functions
*/
function addZeros(num, size) {
    var text = num.toString();
    while (text.length < size) {
        text = "0" + text;
    }
    return text;
}

function secondsToText(secs) {
    var minutes = Math.floor(secs / 60);
    var seconds = secs % 60;
    return minutes + ":" + addZeros(seconds, 2);
}

function timer(clock) {
    clock.counter--;
    $(clock.textID).html(secondsToText(clock.counter));
    if (clock.counter <= 0) {
        clearInterval(clock.interval);
        clock.interval == null;
        blinkDiv(clock.divID, "red");
    }
}

/*
* Point functions
*/
function changePoints(team, amount) {
    if (team == "A") {
        if (teamA.points + amount >= 0 && teamA.points + amount < 1000) {
            teamA.points += amount;
            $(teamA.textID).html(addZeros(teamA.points, 3));
        }
    } else if (team == "B") {
        if (teamB.points + amount >= 0 && teamB.points + amount < 1000) {
            teamB.points += amount;
            $(teamB.textID).html(addZeros(teamB.points, 3));
        }
    }
}

function resetPoints(team) {
    if (team == "A") {
        teamA.points = 0;
        $(teamA.textID).html(addZeros(teamA.points, 3));
    } else if (team == "B") {
        teamB.points = 0;
        $(teamB.textID).html(addZeros(teamB.points, 3));
    }
}

/*
* Clock functions
*/
function startPauseGameClock() {
    if (gameClock.interval == null) {
        gameClock.interval = setInterval(timer, 1000, gameClock);
        $(gameClock.textID).html(secondsToText(gameClock.counter));
    } else {
        clearInterval(gameClock.interval);
        gameClock.interval = null;
        $(gameClock.textID).html(secondsToText(gameClock.counter));
    }
}

function startQuestionClock(secs) {
    if (questionClock.interval != null) {
        clearInterval(questionClock.interval);
        questionClock.interval = null;
        startQuestionClock(secs);
    } else {
        questionClock.counter = secs;
        questionClock.interval = setInterval(timer, 1000, questionClock);
        $(questionClock.textID).html(secondsToText(questionClock.counter));
    }
}

function resetClock(clock) {
    clearInterval(clock.interval);
    clock.interval = null;
    if (clock == gameClock) {
        clock.counter = 480;
    } else if (clock == questionClock) {
        clock.counter = 0;
    }
    $(clock.textID).html(secondsToText(clock.counter));
    $(clock.divID).css("background-color", "");
}

/*
* Ajax functions
*/
function getBuzzer(code) {
    window.setInterval(function () {
        $.post("database-buzzer-get.php",
            { code: code },
            function (data) {
                if (data != null) {
                    while (data.length < 12) {
                        data += " ";
                    }
                    var output = "<pre>Player: " + data + "</pre>";
                    $("#GameLabelText").html(output);
                    clearInterval();
                }
            });
    }, 500);
}

function resetBuzzer(code) {
    $.post("database-buzzer-reset.php",
        { code: code },
        function () {
            $("#GameLabelText").html("<pre>Player:             </pre>");
        });
    getBuzzer(code);
}

/*
* Onload functions
*/
$(window).on('load', function() {
    getBuzzer($("#TeamALabelText").text().substring(6));
})