<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/gameplay-styles.css">
    <script type="text/javascript" src="Player.js"></script>
    <script type="text/javascript" src="PlayerHuman.js"></script>
    <script type="text/javascript" src="PlayerComp.js"></script>
    <script type="text/javascript" src="CookieIO.js"></script>
</head>
<body>
    <div class="container">
        <div class="left">
            <div id="board-shots">
                <div id="comp-board-ships"></div> <!-- Computer's Placement Table -->
            </div>
        </div>
        <div class="right">
            <div id="board-container">
                <div id="board-ships"></div> <!-- Player's Placement Table -->
                <div id="ship-overlay"></div> <!-- Player's Ship image on cells -->
            </div>
        </div>
    </div>
    
    <div class="ship-images" style="display: none;">
        <img src="images/Carrier_big.png" class="ship-image" alt="Carrier [5 Squares]">
        <img src="images/Battleship_big.png" class="ship-image" alt="Battleship [4 Squares]">
        <img src="images/Destroyer_big.png" class="ship-image" alt="Destroyer [3 Squares]">
        <img src="images/Sub_big.png" class="ship-image" alt="Submarine [3 Squares]">
        <img src="images/Patrol_big.png" class="ship-image" alt="Patrol Boat [2 Squares]">
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const p1 = new PlayerHuman();
            const p2 = new PlayerComp();

            // Set up p1 (human player)
            p1.fromJSON(getCookie("p1"));
            p1.updateBoard();
            p1.renderAllPlacedShips();
            
            // Set up p2 (ai player)
            p2.getShipPlacement();

            const compBoardContainer = document.getElementById("comp-board-ships");
            p2.displayShips(compBoardContainer);
            
            // game loop
        });
    </script>
</body>
</html>