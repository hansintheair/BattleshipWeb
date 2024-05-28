<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="Game.js"></script>
    <script type="text/javascript" src="Player.js"></script>
</head>
<body>
    <p id="board-shots"></p>
    <p id="test"></p>
    <script>
        p1 = new Player();
        p1.displayShots(document.getElementById("board-shots"));
        document.getElementById("test").textContent = JSON.stringify(p1.toJSON());
    </script>
</body>
</html>

