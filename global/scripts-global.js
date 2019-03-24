function blinkDiv(divID, color) {
    blinkDivCount(divID, color, 5);
}

function blinkDivCount(divID, color, count) {
    var runs = 0;
    var interval = setInterval(timer, 500);

    function timer() {
        if (runs >= count) {
            $(divID).css("background-color", "");
            clearInterval(interval);
        } else if (runs % 2 == 1) {
            runs += 1;
            $(divID).css("background-color", "");
        } else if (runs % 2 == 0) {
            runs += 1;
            $(divID).css("background-color", color);
        }
    }
}
