function updateServer(user, code) {
    $.post("database-buzzer-update.php",
        { user: user, code: code },
        function () {
            blinkDivCount("#BuzzButton", "#cccccc", 1);
        });
}